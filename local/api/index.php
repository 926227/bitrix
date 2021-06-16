<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1C-Битрикс: Тестирование API");
CUtil::InitJSCore(array('my_jquery'));
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
      <input type="number" min="1" name="iblock" required>
      </label>
      <label>
      Шаг:
      <input type="number" min="1" max="20" name="step" required>
      </label>
      <label>
      Всего добавить:
      <input type="number" min="1" max="200" name="count" required>
      </label>
      <button id="submitButton" type="submit">Сделать запрос</button>
    </form>
    <div id="board" >Добавлено элементов: <span id="number"></span></div>
    <div id="result"></div>
</div>

<script>
  const onSubmit = (evt) => {
    evt.preventDefault();
    if (!formElem[0].value || !formElem[1].value || !formElem[2].value) {
      $('#result').html('Пожалуйста заполните все поля');
      return;
    }
    if (+formElem[1].value > +formElem[2].value) {
      $('#result').html('Пожалуйста, сделайте размер шага меньше общего числа добавляемых элементов');
      return;
    }
    getData(formElem[0].value, formElem[1].value, formElem[2].value)
  }

  formElem.addEventListener('submit', onSubmit);

  const getData = async (iblock, step, count) => {
    const sessid = "<?=bitrix_sessid()?>";
    $('#number').html('');
    $('#result').html('');
    $('#submitButton').attr('disabled', true);

    $.ajax({
      method:"GET",
      url:`api_add.php`,
      data: {iblock, step, count, apikey:'RUN2021', sessid},
      success:function(response) {
        $('#result').html('Добавление завершено.');
        $('#submitButton').attr('disabled', false);
      },
      timeout: 60000,
      error: function (xhr, status, errorThrown ) {
        if (status === 'timeout') {
          $('#result').html('Истек период ожидания ответа сервера.');
          $('#submitButton').attr('disabled', false);
          return;
        }

        $('#result').html(`Призошла ошибка! ${xhr.responseText}`);
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