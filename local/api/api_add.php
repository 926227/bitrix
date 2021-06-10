<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1C-Битрикс: Тестирование API");
global $USER;

echo "Проверка... ";

if ($_SERVER["REQUEST_METHOD"]<>"GET") die();
if ($_GET['apikey']<>'RUN2021') {
  echo "Неверный ключ";
  die();
}
echo "Ключ верный";

$iCount = isset($_GET['COUNT']) ? (int) $_GET['COUNT'] : 0;
$iStep = isset($_GET['STEP']) ? (int) $_GET['STEP'] : 0;
$iBlockId = isset($_GET['IBLOCK']) ? (int) $_GET['IBLOCK'] : 7;
$arAdd = Array("total" => 0, "step" => 0);
CModule::IncludeModule("iblock");
$el = new CIBlockElement;

echo "<br>=====<br>";
echo "Задача: создать $iCount элементов, шаг:$iStep <br>";

?>
<div id="board">
  <h3>Добавление информации в информационный блок.</h3>
</div>

<script>
  let info;
</script>

<?
include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/footer.php");
?>

<?
$i = 0;
while ( $i < $iCount) {
  if ($i % $iStep === 1) {
    ?>
    <script>
      info = document.createElement('p');
      info.textContent = 'Добавляем элементы... ';
      board.append(info);
    </script>
    <?
  }

  if ($i && $i % $iStep === 0) {
    ?>
    <script>
      info.append("добавлено <?=$arAdd["step"]?> элементов");
    </script>
    <?
    $arAdd["step"] = 0;
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

  if($el->Add($arLoadArray))  {
    $arAdd["total"]++;
    $arAdd["step"]++;
  }
}

if ($i % $iStep <> 1) {
  ?>
  <script>
    info.append("добавлено <?=$arAdd["step"]?> элементов");
  </script>
  <?
}

?>

<script>
  info = document.createElement('p');
  info.textContent = `Задача выполнена! Добавлено элементов: <?=$arAdd["total"]?>`;
  board.append(info);
</script>


