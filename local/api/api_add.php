<?
if ($_SERVER["REQUEST_METHOD"]<>"GET") die();

global $USER;
$iCountMax = isset($_GET['COUNT']) ? (int) $_GET['COUNT'] : 0;
$iStep = isset($_GET['STEP']) ? (int) $_GET['STEP'] : 0;
$iBlockId = isset($_GET['IBLOCK']) ? (int) $_GET['IBLOCK'] : 7;
$arAdd = ["addTotal" => 0, "addStep" => 0];

if ($_GET['apikey']<>'RUN2021') {
  echo "Неверный ключ";
  die();
}

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
$el = new CIBlockElement;

$i = 0;
while ($i < $iCountMax) {
  
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
  if ($el->Add($arLoadArray)) {
    $arAdd["addTotal"]++;
    $arAdd["addStep"]++;
  }
  $i++;  

  if ($i >0 && ($i % $iStep === 0 || $i === $iCountMax)) {
    echo json_encode(['addTotal' => $arAdd['addTotal']])."*";
    ob_end_flush();
    flush();
    $arAdd["addStep"] = 0;
  }
}
echo json_encode(['addTotal' => $arAdd['addTotal']]);