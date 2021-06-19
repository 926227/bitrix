<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("1C-Битрикс: Тестирование API");
CUtil::InitJSCore(array('my_api'));
?>
<div class="container" style="height:500px;">
    <h2 class="display-4">Добавление информации в информационный блок.</h2>
    <form id="fillInfoBlockForm">
        <?=bitrix_sessid_post()?>
        <label class="row">
        Номер информационного блока:
        <input class="form-control" type="number" min="1" name="iblock" required>
        </label>
        <label class="row">
        Шаг:
        <input class="form-control" type="number" min="1" max="20" name="step" required>
        </label>
        <label class="row">
        Всего добавить:
        <input class="form-control" type="number" min="1" max="200" name="count" required>
        </label>
        <button class="btn btn-primary" id="submitButton" type="submit">Сделать запрос</button>
    </form>
    <div class="alert alert-primary my-3 " id="board" >Добавлено элементов: <span  id="number"></span></div>
    <div class="alert" id="result"></div>
</div>

<?php
include_once($_SERVER["DOCUMENT_ROOT"].SITE_TEMPLATE_PATH."/footer.php");
