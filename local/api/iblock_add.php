<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");

global $USER;

$iCount = isset($_GET['COUNT']) ? (int) $_GET['COUNT'] : 0;
$iStep = isset($_GET['STEP']) ? (int) $_GET['STEP'] : 0;
$iBlockId = (int) $_GET['IBLOCK2'];
$iStart = isset($_GET['start']) ? (int) $_GET['start'] : 0;
$el = new CIBlockElement;
$i = $iStart;
$iAdded = 0;

// echo json_encode(array('$iStep'=>$iStep, '$iBlockId' => $iBlockId, '$iStart' => $iStart));

while ( $i < ($iStart + $iStep) && $i < $iCount) {
  
  $arProps = Array();
  $arProps['CITY'][0] = "Город #$i";
  $arProps['CITY'][1] = "Страна #$i";
  $arProps['CITY'][2] = "Регион #$i";

  $arLoadArray = Array(
    "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
    "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
    "IBLOCK_ID"      => $iBlockId,
    "PROPERTY_VALUES"=> $arProps,
    "NAME"           => "Тест материал #$i",
    "CODE"           => Cutil::translit("Тест материал #$i", "ru"),
    "ACTIVE"         => "Y",            // активен
    "PREVIEW_TEXT"   => "Добавлено с помощью скрипта",
    "DETAIL_TEXT"    => "Добавлено с помощью скрипта",
    );

  $i++;  

  
  if($el->Add($arLoadArray))  $iAdded++;
}

echo json_encode(array("elementsAdded" => $iAdded));