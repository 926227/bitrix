<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
{
	die();
}

// dump($arResult,true, false, true);

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

\Bitrix\Main\Page\Asset::getInstance()->addCss(
	'/bitrix/css/main/system.auth/flat/style.css'
);
global $USER;

?>
<?if ($arResult['AUTHORIZED']):?>
	<span class="hd_sing">
		<?=$USER->GetFullName()?> [<a href="/user/profile.php"><?=$USER->GetLogin()?></a>]
	</span>
	<a href="<?=$APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), array(
		"login",
		"logout",
		"register",
		"forgot_password",
		"change_password"))?>" class="hd_signup"><?=GetMessage("MAIN_AUTH_FORM_LOGOUT")?></a>	

	<?return?>
<?endif;?>

<div class="bx-authform">

	<?if ($arResult['ERRORS']):?>
	<div class="alert alert-danger">
		<? foreach ($arResult['ERRORS'] as $error)
		{
			echo $error;
		}
		?>
	</div>
	<?endif;?>

<span class="hd_singin">
	<a id="hd_singin_but_open" href="">
		<?= Loc::getMessage('MAIN_AUTH_FORM_HEADER');?>
	</a>
	<div class="hd_loginform">
		<span class="hd_title_loginform">
			<?= Loc::getMessage('MAIN_AUTH_FORM_HEADER');?>
		</span>
	
		<form name="<?= $arResult['FORM_ID'];?>" method="post" target="_top" action="<?= POST_FORM_ACTION_URI;?>">

			<input 
				placeholder="<?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_LOGIN');?>"
				type="text"
				name="<?= $arResult['FIELDS']['login'];?>"
				value="<?= \htmlspecialcharsbx($arResult['LAST_LOGIN']);?>"
				maxlength="255">	
		
			<input
				placeholder="<?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_PASS');?>"  
				type="password"
				name="<?= $arResult['FIELDS']['password'];?>"
				maxlength="255"
				autocomplete="off">
			
			<?if ($arResult['AUTH_FORGOT_PASSWORD_URL']):?>
			<noindex>
				<a 
				href="<?= $arResult['AUTH_FORGOT_PASSWORD_URL'];?>" 
				class="hd_forgotpassword"
				rel="nofollow">
					<?= Loc::getMessage('MAIN_AUTH_FORM_URL_FORGOT_PASSWORD');?>
				</a>
			</noindex>
			<?endif;?>

			<?if ($arResult['STORE_PASSWORD'] == 'Y'):?>
				<div class="head_remember_me" style="margin-top: 10px">
					<input 
						id="USER_REMEMBER_frm" 
						name="<?= $arResult['FIELDS']['remember'];?>" 
						value="Y" 
						type="checkbox">
					<label 
						for="USER_REMEMBER_frm" 
						title="<?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_REMEMBER');?>">
						<?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_REMEMBER');?>
					</label>
				</div>
			<?endif?>

			<?if ($arResult['CAPTCHA_CODE']):?>
				<input type="hidden" name="captcha_sid" value="<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']);?>" />
				<div class="bx-authform-formgroup-container dbg_captha">
					<div class="bx-authform-label-container">
						<?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_CAPTCHA');?>
					</div>
					<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?= \htmlspecialcharsbx($arResult['CAPTCHA_CODE']);?>" width="180" height="40" alt="CAPTCHA" /></div>
					<div class="bx-authform-input-container">
						<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off" />
					</div>
				</div>
			<?endif;?>

			<input 
				value="<?= Loc::getMessage('MAIN_AUTH_FORM_FIELD_SUBMIT');?>" 
				name="<?= $arResult['FIELDS']['action'];?>" 
				style="margin-top: 20px;" 
				type="submit">
			
		</form>
		<span class="hd_close_loginform">Закрыть</span>
	</div>
</span><br>
<?if ($arResult['AUTH_REGISTER_URL']):?>
<noindex>
	<a 
		class="hd_signup"
		href="<?= $arResult['AUTH_REGISTER_URL'];?>" 
		rel="nofollow">
			<?= Loc::getMessage('MAIN_AUTH_FORM_URL_REGISTER_URL');?>
	</a>
</noindex>
<?endif;?>
<!-- <script type="text/javascript">
	<?if ($arResult['LAST_LOGIN'] != ''):?>
	try{document.<?= $arResult['FORM_ID'];?>.USER_PASSWORD.focus();}catch(e){}
	<?else:?>
	try{document.<?= $arResult['FORM_ID'];?>.USER_LOGIN.focus();}catch(e){}
	<?endif?>
</script> -->
