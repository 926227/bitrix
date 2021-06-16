<?php
$arJsConfig = array( 
  'my_jquery' => array( 
      'js' => 'https://code.jquery.com/jquery-3.4.1.min.js', 
  ) 
); 

foreach ($arJsConfig as $ext => $arExt) { 
  \CJSCore::RegisterExt($ext, $arExt); 
}