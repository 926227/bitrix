<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
if ($_SERVER["REQUEST_METHOD"]<>"GET") exit();
if (!check_bitrix_sessid()) {
  header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
  exit();
};

const KEY_TO_START_SCRIPT = 'RUN2021';
global $USER;

$oInstance = \Bitrix\Main\Application::getInstance();
$oContext = $oInstance->getContext();
$oRequest = $oContext->getRequest();

if (!$oRequest->isAjaxRequest()) {
  echo "Должен быть ajax запрос";
  exit();
}

$sCheckStartScriptKey = $oRequest->getQuery("apikey");

if( $sCheckStartScriptKey <> KEY_TO_START_SCRIPT){
  header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
  echo "wrong apikey";
  exit();
}

CModule::IncludeModule("iblock");
$oInfoBlockElement = new CIBlockElement;

$iTotalNumberOfElementsToAdd = $oRequest->getQuery("count") ? (int) $oRequest->getQuery("count") : 0;
$iStepNumberOfElementsToAdd = $oRequest->getQuery("step") ? (int) $oRequest->getQuery("step") : 1;
$iIBlockId = $oRequest->getQuery("iblock") ? (int) $oRequest->getQuery("iblock") : 7;
$arAddElementsCounter = ["addTotal" => 0, "addDuringStep" => 0];


if ($iTotalNumberOfElementsToAdd < 1 || $iStepNumberOfElementsToAdd < 1 || $iTotalNumberOfElementsToAdd < $iStepNumberOfElementsToAdd){
  header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
  exit();
}

$iProposeElementNumber = 0 ;
while ($arAddElementsCounter["addTotal"] < $iTotalNumberOfElementsToAdd) {

  $arProps = Array();
  $arProps['CITY'][0] = "Город #$iProposeElementNumber";
  $arProps['CITY'][1] = "Страна #$iProposeElementNumber";
  $arProps['CITY'][2] = "Регион #$iProposeElementNumber";
  
  $arLoadArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iIBlockId,
    "PROPERTY_VALUES"=> $arProps,
    "NAME"           => "Тест материал #$iProposeElementNumber",
    "CODE"           => Cutil::translit("Тест материал #$iProposeElementNumber", "ru"),
    "ACTIVE"         => "Y",            // активен
    "PREVIEW_TEXT"   => "Добавлено с помощью скрипта",
    "DETAIL_TEXT"    => "Добавлено с помощью скрипта",
  );
  if ($oInfoBlockElement->Add($arLoadArray)) {
    $arAddElementsCounter["addTotal"]++;
    $arAddElementsCounter["addDuringStep"]++;
  }

  if ($arAddElementsCounter["addDuringStep"] > 0 && ($arAddElementsCounter["addDuringStep"] >= $iStepNumberOfElementsToAdd ||  $arAddElementsCounter["addTotal"] === $iTotalNumberOfElementsToAdd)) {
    echo json_encode(['addTotal' => $arAddElementsCounter['addTotal']])."*";
    ob_end_flush();
    flush();
    $arAddElementsCounter["addDuringStep"] = 0;
  }

  $iProposeElementNumber++;
}