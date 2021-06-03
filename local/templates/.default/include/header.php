<div class="hd_header_area">
			<div class="hd_header">
				<table>
					<tr>
						<td rowspan="2" class="hd_companyname">
							<h1><?$APPLICATION->ShowTitle(false)?></h1>
						</td>
						<td rowspan="2" class="hd_txarea">
							<span class="tel">
								<?$APPLICATION->IncludeComponent(
									"bitrix:main.include",
									"",
									Array(
										"AREA_FILE_SHOW" => "file",
										"AREA_FILE_SUFFIX" => "inc",
										"EDIT_TEMPLATE" => "",
										"PATH" => "/include/phone.php"
									)
								);?>
							</span>	
							<br/>	
							<?=GetMessage('WORKING_TIME')?> <span class="workhours">ежедневно с 9-00 до 18-00</span>						
						</td>
						<td style="width:232px">
							<form action="">
								<div class="hd_search_form" style="float:right;">
									<input placeholder="Поиск" type="text"/>
									<input type="submit" value=""/>
								</div>
							</form>
						</td>
					</tr>
					<tr>
						<td style="padding-top: 11px;">
						<?$APPLICATION->IncludeComponent(
	"bitrix:main.auth.form", 
	"auth", 
	array(
		"AUTH_FORGOT_PASSWORD_URL" => "/user/?forgot_password=yes",
		"AUTH_REGISTER_URL" => "/user/registration.php",
		"AUTH_SUCCESS_URL" => "/user/profile.php",
		"COMPONENT_TEMPLATE" => "auth"
	),
	false
);?>
						</td>
					</tr>
				</table>
				<?$APPLICATION->IncludeComponent(
	"bitrix:menu", 
	"top_multi", 
	array(
		"ALLOW_MULTI_SELECT" => "N",
		"CHILD_MENU_TYPE" => "left",
		"DELAY" => "N",
		"MAX_LEVEL" => "2",
		"MENU_CACHE_GET_VARS" => array(
		),
		"MENU_CACHE_TIME" => "3600",
		"MENU_CACHE_TYPE" => "A",
		"MENU_CACHE_USE_GROUPS" => "Y",
		"ROOT_MENU_TYPE" => "top",
		"USE_EXT" => "N",
		"COMPONENT_TEMPLATE" => "top_multi"
	),
	false
);?>
				
			</div>
		</div>