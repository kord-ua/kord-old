<?php

namespace KORD\Filtration\Word;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class DashToSeparatorSrc extends SeparatorToSeparator
{
    
    /**
     * Filter options
     *
     * @var array
     */
    protected $options = [
        'replacement_separator' => null
    ];
    
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
