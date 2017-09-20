<?php

/**
 * Created by PhpStorm.
 * User: Pavlo
 * Date: 17.09.2017
 * Time: 15:47
 */
class Validator
{
    /**
     * validate search-form
     * @param array $post
     * @return array $errors
     */
    public static function searchForm( $post = array() )
    {
        $count = 0;
        $messages = array();

        if(empty($post['code'])) {
            $count++;
            $messages['code']['required'] = "The field code is required!";
        }

        if ($count == 0 and !self::isCiao($post['code'])) {
            $count++;
            $messages['code']['valid'] = "The field search is not valid!";
        }

        return array(
            'count' => $count,
            'messages' => $messages
        );
    }


    /**
     * CIAO code validation
     * @param string $str
     * @return bool $res
     */
    protected static function isCiao($str)
    {
        $regex = '/[a-zA-Z]{4}/i';

        if (strlen($str) > 4) return false;
        if (strlen($str) < 4) return false;
        if (preg_match($regex, str_replace('', '', $str), $matches)) return true;

        return false;
    }

}