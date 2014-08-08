<?php

namespace KORD\Filtration\Word;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
class CamelCaseToUnderscoreSrc extends CamelCaseToSeparator
{

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
