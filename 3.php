<?php
function validator($input){
    $open = array();

    foreach ($input as $item){
        if (strpos($item, '/') === false){
            $open[] = $item;
        } else{
            $item_close = array_pop($open);
            $check_tag = str_replace("/", "", $item);
            if($item_close != $check_tag){
                return 'This document is invalid!';
            }
        }
    }
    if(sizeof($open) == 0){
        return 'This document is valid!';
    } else{
        return 'This document is invalid!';
    }
}

$test = array('<a>', '<div>', '</div>', '</a>');
echo validator($test);
 ?>
