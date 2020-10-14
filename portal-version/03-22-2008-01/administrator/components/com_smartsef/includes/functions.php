<?php
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();


function smart_import ( $lib_path ) {

	$path  = JPATH_ROOT .  DS. 'libraries' . DS. str_replace( '.', DS, $lib_path ) . '.php';
	include_once ( $path );
}

function mKey($len = 12, $type = 'ALNUM')
{
    // Register the lower case alphabet array
    $alpha = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm',
                   'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z');

    // Register the upper case alphabet array
    $ALPHA = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M',
                     'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

    // Register the numeric array
    $num = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');

    // Initialize the keyVals array for use in the for loop
    $keyVals = array();

    // Initialize the key array to register each char
    $key = array();

    // Loop through the choices and register
    // The choice to keyVals array
    switch ($type)
    {
        case 'lower' :
            $keyVals = $alpha;
            break;
        case 'upper' :
            $keyVals = $ALPHA;
            break;
        case 'numeric' :
            $keyVals = $num;
            break;
        case 'ALPHA' :
            $keyVals = array_merge($alpha, $ALPHA);
            break;
        case 'ALNUM' :
            $keyVals = array_merge($alpha, $ALPHA, $num);
            break;
    }

    // Loop as many times as specified
    // Register each value to the key array
    for($i = 0; $i <= $len-1; $i++)
    {
        $r = rand(0,count($keyVals)-1);
        $key[$i] = $keyVals[$r];
    }

    // Glue the key array into a string and return it
    return join("", $key);
}
?>