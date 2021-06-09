<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1C-Битрикс: Тестирование API");

echo "Проверка...<br>";

if ($_SERVER["REQUEST_METHOD"]<>"GET") die();
if ($_GET['apikey']<>'RUN2021') die();

$iCount = isset($_GET['COUNT']) ? (int) $_GET['COUNT'] : 0;
$iStep = isset($_GET['STEP']) ? (int) $_GET['STEP'] : 0;
$iBlockId = isset($_GET['IBLOCK']) ? (int) $_GET['IBLOCK'] : 7;

echo "=====<br>";
echo "Задача: создать $iCount элементов, шаг:$iStep <br>";



?>
<div id="board">
  <h3>Добавление информации в информационный блок.</h3>
</div>

<script>
const pushElements = async () =>{
  const count = <?=$iCount?>;
  const step = <?=$iStep?>;
  const iBlock = <?=$iBlockId?>;
  let n = 0;
  let added = 0;

  if (step < 0 || count < 0) {
    const info = document.createElement('p');
    info.textContent = 'Неверные значения показателей';
    info.setAttribute('style', 'color:red;')
    board.append(info);
    return;
  }

  while (n < count) {
    const info = document.createElement('p');
    info.textContent = 'Добавляем элементы... ';
    board.append(info);

    const response = await fetch(`./iblock_add.php/?IBLOCK2=${iBlock}&STEP=${step}&COUNT=${count}&start=${n}`);
    const result = await response.json();

    info.append(`добавлено ${result.elementsAdded} элементов.`)

    added += result.elementsAdded;
    n += step;
  }

  info = document.createElement('p');
  info.textContent = `Задача выполнена! Добавлено элементов: ${added}`;
  board.append(info);
}
pushElements();
</script>



<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>