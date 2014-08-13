<?php

namespace KORD\Security;

use KORD\HTMLPurifier;

/**
 * XSS protection security class
 * 
 * @copyright  (c) 2014 Andriy Strepetov
 */
class XSSSrc
{

    /**
     * Removes XSS (and broken HTML) from text using [HTMLPurifier](http://htmlpurifier.org/).
     *
     * $text = XSS::clean($_POST['text']);
     *
     * @param mixed $data  text/array to clean
     * @return mixed
     */
    public static function clean($data)
    {
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $data[$key] = XSS::clean($value);
            }
        }
        
        return HTMLPurifier::getInstance()->purify($data);
    }

}
