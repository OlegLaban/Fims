<?php
/**
 * Created by PhpStorm.
 * User: gelo
 * Date: 26.3.19
 * Time: 16.00
 */

class Other
{

    public static function getYear($unixTime)
    {
        return date("d.M.Y",   $unixTime);
    }

}