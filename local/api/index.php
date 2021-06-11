<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1C-Битрикс: Тестирование API");

?>

<style>
label {
  display: block;
  margin-bottom: 10px;
}
form{
  margin-bottom: 20px;
}
</style>

<div class="container" style="height:500px;">
    <h3>Добавление информации в информационный блок.</h3>
    <form id="formElem">
      <label>
      Номер информационного блока:
      <input type="number" name="iblock" required>
      </label>
      <label>
      Шаг:
      <input type="number" name="step" required>
      </label>
      <label>
      Всего добавить:
      <input type="number" name="count" required>
      </label>
      <button id="submitButton" type="submit">Сделать запрос</button>
    </form>
    <div id="board" >Добавлено элементов: <span id="number"></span></div>
    <div id="result"></div>
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script>
  const onSubmit = (evt) => {
    evt.preventDefault();
    if (!formElem[0].value || !formElem[1].value || !formElem[2].value) {
      $('#result').html('Пожалуйста заполните все поля');
    }
    getData(formElem[0].value, formElem[1].value, formElem[2].value)
  }

  formElem.addEventListener('submit', onSubmit);

  const getData = async (iblock, step, count) => {
    $('#number').html('');
    $('#result').html('');
    $('#submitButton').attr('disabled', true);

    $.ajax({
      url:`http://bitrix.loc/local/api/api_add.php?IBLOCK=${iblock}&STEP=${step}&COUNT=${count}&apikey=RUN2021`,
      success:function(response) {
        $('#result').html('Добавление элементов завершено.');
        $('#submitButton').attr('disabled', false);
      },
      xhr: function(){
          let xhr = $.ajaxSettings.xhr() ;
          xhr.onprogress = function(evt){ 
            const serverResult = evt.currentTarget.responseText.split('*');
            const elementsAdded = JSON.parse(serverResult[serverResult.length - 2]).addTotal;
            $('#number').html(elementsAdded);
          };
          return xhr ;
      }
    });
}
</script>
<?
include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/footer.php");