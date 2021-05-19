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