<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1C-Битрикс: Тестирование API");

?>
<div class="container" style="height:500px;">
    <h3>Добавление информации в информационный блок.</h3>
    <form id="formElem">
      <label>
      Номер информационного блока:
      <input type="text" name="iblock">
      </label>
      <br>
      <label>
      Шаг:
      <input type="text" name="step">
      </label>
      <br>
      <label>
      Всего добавить:
      <input type="text" name="count">
      </label>
      <br>
      <button type="submit">Сделать запрос</button>
    </form>

    <div id="board" ></div>
</div>

<script>
  const onSubmit = (evt) => {
    evt.preventDefault();
    getData(formElem[0].value, formElem[1].value, formElem[2].value)
  }

  formElem.addEventListener('submit', onSubmit);

  const getData = async (iblock, step, count) => {
    let response = await fetch(`http://bitrix.loc/local/api/api_add.php?IBLOCK=${iblock}&STEP=${step}&COUNT=${count}&apikey=RUN2021`);
    const reader = response.body.getReader();
    let result;

    board.innerHTML = '';
    let info = document.createElement('h3');
    info.textContent = 'Добавляем элементы:';
    board.append(info);

    while(true) {
      const {done, value} = await reader.read();

      if (done) {
        break;
      }

      const text = new TextDecoder("utf-8").decode(value);
      result = JSON.parse(text);
      info = document.createElement('p');
      info.textContent = `Добавлено элементов: ${result.addStep}`;
      board.append(info);
      console.log(result);
    }

    info = document.createElement('p');
    info.textContent = `Всего добавлено элементов: ${result.addTotal}`;
    board.append(info);
    console.log('Total:', result.addTotal)
  };
</script>
<?
include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/footer.php");