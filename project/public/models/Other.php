<?php
/**
 * Created by PhpStorm.
 * User: gelo
 * Date: 26.3.19
 * Time: 16.00
 */

class Other
{

    public static function FirstOrLastLitera($litera, $bool = false)
    {
        if(preg_match('/[A-Z]|[a-z]/', $litera)){
            if($bool){
                return 'A';
            }else{
                return 'Z';
            }

        }
        if(preg_match('/[А-Я]|[а-я]/', $litera)){
            if($bool){
                return 'А';
            }else{
                return 'Я';
            }
        }
    }

    public static function getYear($unixTime)
    {
        return date("d.M.Y",   $unixTime);
    }

}