<?php

class Filter
{
    /**
     * @param   string  $string
     *
     * @return  string
     */
    public static function sanitize( $string )
    {
        $string = trim($string);
        $string = stripslashes($string);
        $string = htmlspecialchars($string);

        return ( strlen($string) > 0 ? $string : NULL );
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
}