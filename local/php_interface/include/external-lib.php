<?php
$arJsConfig = array(
    'jquery' => [
        'jquery' => '/bitrix/main/jquery/jquery-3.3.1.min.js'
    ],
    'my_api' => [
        'js' => '/local/api/script.js',
        'css' => '/bitrix/css/main/bootstrap_v4/bootstrap.min.css',
        'rel' => ['jquery'],
        ]
); 

foreach ($arJsConfig as $ext => $arExt) { 
  CJSCore::RegisterExt($ext, $arExt);
}

//'jquery' => '/bitrix/main/jquery/jquery-3.3.1.min.js',
