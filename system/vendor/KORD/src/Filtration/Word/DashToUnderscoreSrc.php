<?php

namespace KORD\Filtration\Word;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
class DashToUnderscoreSrc extends SeparatorToSeparator
{
    
    /**
     * Returns the actual set separator to search for
     *
     * @return string
     */
    public function getSearchSeparator()
    {
        return '-';
    }
    
    /**
     * Returns the actual set separator which replaces the searched one
     *
     * @return string
     */
    public function getReplacementSeparator()
    {
        return '_';
    }

}
