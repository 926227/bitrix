<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1C-Битрикс: Тестирование API");

echo "Проверка...<br>";

if ($_SERVER["REQUEST_METHOD"]<>"GET") die();
if ($_GET['apikey']<>'RUN2021') die();
if(!CModule::IncludeModule("iblock")) die();

global $USER;

$iCount = isset($_GET['COUNT']) ? (int) $_GET['COUNT'] : 0;
$iStep = isset($_GET['STEP']) ? (int) $_GET['STEP'] : 0;
$iBlockId = 7;

echo "=====<br>";
echo "Задача: создать $iCount элементов, шаг:$iStep <br>";

$el = new CIBlockElement;
$i=0;

while ($i < $iCount) {
  if ($i % $iStep === 0) {
    echo "добавлены очередные элементы  + $iStep штуки<br>";
  }

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

  $el->Add($arLoadArray);

}
echo "=====<br>";
echo "Задача выполнена..."
?>

<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>