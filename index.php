<?php
/**
 * Simple PHP Status Page!
 * Author: Wynter Emerson (bluerose.dev - wynter@bluerose.dev)
 * License: MIT
 */
include_once('header.php');

$modules = scandir('./modules');
foreach($modules as $key=>$value){
    if($value != '.' && $value != '..'){
        require('modules/'.$value);
    }
}

include('./footer.php');
