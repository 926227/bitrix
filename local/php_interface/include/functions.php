<?php
function dump($var, $print = false, $die = false, $all = false)
{
    global $USER;
    if($USER->IsAdmin() || ($all == true))
    {
        if ($print) {
            ?>
            <pre><?print_r($var)?></pre><br>
            <?
            return;
        }
        
        ?>
        <pre><?var_dump($var)?></pre><br>
        <?
    }
    if($die)
    {
        die;
    }
}

function deleteKernelCss(&$content) {
    global $USER, $APPLICATION;
    if(strpos($APPLICATION->GetCurDir(), "/bitrix/")!==false) return;
    if($APPLICATION->GetProperty("save_kernel") == "Y") return;
    $arPatternsToRemove = Array(
        '/<link.+?href=".+?bitrix\/css\/main\/bootstrap.css[^"]+"[^>]+>/',
        '/<link.+?href=".+?bitrix\/css\/main\/bootstrap.min.css[^"]+"[^>]+>/',
    );
    $content = preg_replace($arPatternsToRemove, "", $content);
    $content = preg_replace("/\n{2,}/", "\n\n", $content);
    }
