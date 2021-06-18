<?php

use Bitrix\Main\Application;
global $USER;
const KEY_TO_START_SCRIPT = 'RUN2021';
class elementAddExeption extends Exception{};

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
}
try{
    if ($_SERVER["REQUEST_METHOD"] <> "GET") throw new Exception(' 500 Server Error');
    if (!check_bitrix_sessid()) throw new Exception(' 500 Server Error');

    $oInstance = Application::getInstance();
    $oContext = $oInstance->getContext();
    $oRequest = $oContext->getRequest();

    if (!$oRequest->isAjaxRequest()) throw new Exception(' 500 Server Error');

    $sCheckStartScriptKey = $oRequest->getQuery("apikey");
    if ($sCheckStartScriptKey <> KEY_TO_START_SCRIPT) throw new Exception(' 500 Server Error');

    $iTotalNumberOfElementsToAdd = (int)$oRequest->getQuery("count") ?? 0;
    $iStepNumberOfElementsToAdd = (int)$oRequest->getQuery("step") ?? 1;
    $iIBlockId = (int)$oRequest->getQuery("iblock") ?? 7;
    $arAddElementsCounter = ["addTotal" => 0, "addDuringStep" => 0];

    if ($iTotalNumberOfElementsToAdd < 1 || $iStepNumberOfElementsToAdd < 1 || $iTotalNumberOfElementsToAdd <
        $iStepNumberOfElementsToAdd) throw new Exception(' 400 Bad Request');

    CModule::IncludeModule("iblock");
    $oInfoBlockElement = new CIBlockElement();
    $iNumberOfElementsInfoBlock = CIBlockElement::GetList(
        array(),
        array('IBLOCK_ID' => $iIBlockId),
        array(),
        false,
        array('ID', 'NAME')
    );
    $iProposeElementNumber = $iNumberOfElementsInfoBlock + 1;

    while ($arAddElementsCounter["addTotal"] < $iTotalNumberOfElementsToAdd) {
        $arProps = array();
        $arProps['CITY'][0] = "Город #$iProposeElementNumber";
        $arProps['CITY'][1] = "Страна #$iProposeElementNumber";
        $arProps['CITY'][2] = "Регион #$iProposeElementNumber";

        $arLoadArray = array(
            "MODIFIED_BY" => $USER->GetID(),
            "IBLOCK_SECTION_ID" => false,
            "IBLOCK_ID" => $iIBlockId,
            "PROPERTY_VALUES" => $arProps,
            "NAME" => "Тест материал #$iProposeElementNumber",
            "CODE" => Cutil::translit("Тест материал #$iProposeElementNumber", "ru"),
            "ACTIVE" => "Y",
            "PREVIEW_TEXT" => "Добавлено с помощью скрипта",
            "DETAIL_TEXT" => "Добавлено с помощью скрипта",
        );
        if ($oInfoBlockElement->Add($arLoadArray)) {
            $arAddElementsCounter["addTotal"]++;
            $arAddElementsCounter["addDuringStep"]++;
        } else {
            throw new elementAddExeption($oInfoBlockElement->LAST_ERROR);
        }

        if ($arAddElementsCounter["addDuringStep"] > 0 && ($arAddElementsCounter["addDuringStep"] >= $iStepNumberOfElementsToAdd || $arAddElementsCounter["addTotal"] === $iTotalNumberOfElementsToAdd)) {
            echo json_encode(['addTotal' => $arAddElementsCounter['addTotal']]) . "*";
            ob_end_flush();
            flush();
            $arAddElementsCounter["addDuringStep"] = 0;
        }

        $iProposeElementNumber++;
    }
}
catch (elementAddExeption $e){
    header($_SERVER['SERVER_PROTOCOL'] . ' 500 Server Error');
    echo $e->getMessage();
    exit();
}
catch (Exception $e){
    header($_SERVER['SERVER_PROTOCOL'] . $e->getMessage());
    exit();
}
