<?php
function dump($var, $die = false, $all = false)
{
    global $USER;
    if( ($USER->GetID() == 1) || ($all == true))
    {
        ?>
        <pre><?var_dump($var)?></pre><br>
        <?
    }
    if($die)
    {
        die;
    }
}