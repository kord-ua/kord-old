<?php

namespace KORD\Filtration\Word;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
class DashToCamelCaseSrc extends SeparatorToCamelCase
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

}
