<?php
function getTitle()
{
    global $pageTitel;
    if (isset($pageTitel)) {
        echo $pageTitel;
    } else {
        echo  'Defult';
    }
}
