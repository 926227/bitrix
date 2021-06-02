<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
IncludeTemplateLangFile(__FILE__);
?>
<!DOCTYPE HTML>
<html lang="<?=LANGUAGE_ID?>">
<head>
	<?$APPLICATION->ShowHead();?>
	<title><?$APPLICATION->ShowTitle()?></title>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/../.default/js/jquery-1.8.2.min.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/../.default/js/slides.min.jquery.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/../.default/js/jquery.carouFredSel-6.1.0-packed.js"></script>
	<script type="text/javascript" src="<?=SITE_TEMPLATE_PATH?>/../.default/js/functions.js"></script>
	<link rel="stylesheet" href="/local/templates/.default/template_styles.css">
	<link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/../.default/favicon.ico" type="image/x-icon">
	
	<!--[if gte IE 9]><style type="text/css">.gradient {filter: none;}</style><![endif]-->
</head>
<body>
<?$APPLICATION->ShowPanel();?>
	<div class="wrap">
		<? include_once($_SERVER["DOCUMENT_ROOT"] . "/local/templates/.default/include/header.php");?>
		
		<!--- // end header area --->
		<?$APPLICATION->IncludeComponent(
			"bitrix:breadcrumb",
			"nav",
			Array(
				"PATH" => "",
				"SITE_ID" => "s1",
				"START_FROM" => "0"
			)
		);?>
		<div class="main_container page">
			<div class="mn_container">
				<div class="mn_content">
					<div class="main_post">
						<div class="main_title">
							<p class="title"><?$APPLICATION->ShowTitle(false)?></p>
						</div>