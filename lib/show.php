<?php

if( function_exists('show')===false )
{
    function show( $string )
    {
        echo '<pre>';
        print_r($string);
        echo  '</pre>';
    }
}