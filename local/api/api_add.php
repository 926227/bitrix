<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

use Bitrix\Main\Application;
global $USER;
define(DEFAULT_VALUES, [
    "keyToStartScript" => 'RUN2021',
    "infoBlockNumber" => 7,
    "stepNumberOfElementsToAdd" => 1,
    "totalNumberOfElementsToAdd" => 1
]);
define("CURRENT_USER_ID", $USER->GetID());

class elementAddExeption extends Exception
{
}

try {
    $oInstance = Application::getInstance();
    $oContext = $oInstance->getContext();
    $oRequest = $oContext->getRequest();
    $sCheckStartScriptKey = $oRequest->getQuery("apikey");

    if ($_SERVER["REQUEST_METHOD"] <> "GET"
        || !check_bitrix_sessid()
        || !$oRequest->isAjaxRequest()
        || $sCheckStartScriptKey <> DEFAULT_VALUES["keyToStartScript"]) {
        throw new Exception(' 500 Server Error');
    }

    $iTotalNumberOfElementsToAdd = (int)$oRequest->getQuery("count")
        ?? DEFAULT_VALUES["totalNumberOfElementsToAdd"];
    $iStepNumberOfElementsToAdd = (int)$oRequest->getQuery("step")
        ?? DEFAULT_VALUES["stepNumberOfElementsToAdd"];
    $iIBlockId = (int)$oRequest->getQuery("iblock")
        ?? DEFAULT_VALUES["infoBlockNumber"];
    $arAddElementsCounter = ["addTotal" => 0, "addDuringStep" => 0];

    if ($iTotalNumberOfElementsToAdd < 1
        || $iStepNumberOfElementsToAdd < 1
        || $iTotalNumberOfElementsToAdd < $iStepNumberOfElementsToAdd) {
        throw new Exception(' 400 Bad Request');
    }

    $oInfoBlockElement = new CIBlockElement();
    $iNumberOfElementsInfoBlock = CIBlockElement::GetList(
        [],
        ['IBLOCK_ID' => $iIBlockId],
        [],
        false,
        ['ID', 'NAME']
    );
    $iProposeElementNumber = $iNumberOfElementsInfoBlock + 1;

    while ($arAddElementsCounter["addTotal"] < $iTotalNumberOfElementsToAdd) {
        $arProps = [];
        $arProps['CITY'][0] = "Город #$iProposeElementNumber";
        $arProps['CITY'][1] = "Страна #$iProposeElementNumber";
        $arProps['CITY'][2] = "Регион #$iProposeElementNumber";

        $arLoadArray = [
            "MODIFIED_BY" => CURRENT_USER_ID,
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $iIBlockId,
            "PROPERTY_VALUES" => $arProps,
            "NAME" => "Тест материал #$iProposeElementNumber",
            "CODE" => Cutil::translit("Тест материал #$iProposeElementNumber", "ru"),
            "ACTIVE" => "Y",
            "PREVIEW_TEXT" => "Добавлено с помощью скрипта",
            "DETAIL_TEXT" => "Добавлено с помощью скрипта",
        ];
        if ($oInfoBlockElement->Add($arLoadArray)) {
            $arAddElementsCounter["addTotal"]++;
            $arAddElementsCounter["addDuringStep"]++;
        } else {
            throw new elementAddExeption($oInfoBlockElement->LAST_ERROR);
        }

        if ($arAddElementsCounter["addDuringStep"] > 0
            && ($arAddElementsCounter["addDuringStep"] >= $iStepNumberOfElementsToAdd
                || $arAddElementsCounter["addTotal"] === $iTotalNumberOfElementsToAdd)) {
            echo json_encode(['addTotal' => $arAddElementsCounter['addTotal']]) . "*";
            ob_end_flush();
            flush();
            $arAddElementsCounter["addDuringStep"] = 0;
        }

        $iProposeElementNumber++;
    }
} catch (elementAddExeption $e) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Server Error');
    echo $e->getMessage();
    exit();
} catch (Exception $e) {
    header($_SERVER['SERVER_PROTOCOL'] . $e->getMessage());
    exit();
}
