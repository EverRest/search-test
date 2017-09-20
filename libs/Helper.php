<?php

class Helper
{
    /**
     * Return base url
     * @param string $route
     * @return string $protocol
     */
    public static function url($route = false)
    {
//        if ($route) {
//            if(isset($_SERVER['HTTPS'])){
//                $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
//            }
//            else{
//                $protocol = 'http';
//            }
//
//            $protocol .= "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . $route;
//            return $protocol;
//
//        } else {
//            die('Error: Wrong url path.');
//        }
    }

    /**
     * Redirect
     * @param string $route
     * @return void
     */
    public static function redirect($str = false)
    {
        $str? header('location: ' . URL . $str) : header('location: ' . URL);
    }

    /**
     *  xml to array convert
     * @param $xmlObject
     * @param array $out
     * @return array
     */
    public static function xml2array ( SimpleXMLElement $parent )
    {
        $array = array();

        foreach ($parent as $name => $element) {
            ($node = & $array[$name])
            && (1 === count($node) ? $node = array($node) : 1)
            && $node = & $node[];

            $node = $element->count() ? self::xml2array($element) : trim($element);
        }

        return $array;
    }
}