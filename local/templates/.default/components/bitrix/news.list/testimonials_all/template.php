<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<?foreach($arResult["ITEMS"] as $arItem):?>
	<?
	$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
	$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
	?>
	
	<div class="review-block" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
		<div class="review-text">
			<div class="review-block-title"><span class="review-block-name"><a href="#"><?=$arItem["NAME"]?></a></span><span class="review-block-description"><?=$arItem["PROPERTIES"]["POSITION"]["VALUE"]?> <?=$arItem["PROPERTIES"]["COMPANY"]["VALUE"]?></span></div>
			<div class="review-text-cont">
				<?=$arItem["DETAIL_TEXT"]?>
			</div>
		</div>
		<div class="review-img-wrap"><a href="#"><img src="<?=$arItem["PREVIEW_PICTURE"]["SRC"]?>" width="66" height="66" alt="img"></a></div>
	</div>
<?endforeach;?>

<div class="review-feedback-form-wrap">
	<div class="review-feedback-form-title">Оставьте свой отзыв</div>
	<form class="review-feedback-form">
		<div class="review-feedback-field-wrap">
			<span class="review-feedback-field">
				<span class="review-feedback-field-title">Имя и фамилия</span>
				<input class="review-feedback-inp" type="text"/></span><span
			class="review-feedback-field">
					<span class="review-feedback-field-title">Должность/компания</span>
					<input class="review-feedback-inp" type="text"/>
			</span>
		</div>

		<div class="review-feedback-text">
			<div class="review-feedback-text-title">Текст отзыва</div>
			<textarea class="review-feedback-text-field"></textarea>
		</div>
		<div class="review-feedback-btn-block">
			<input class="review-feedback-btn" value="Оставить свой отзыв" type="submit"/>
		</div>
	</form>
</div>