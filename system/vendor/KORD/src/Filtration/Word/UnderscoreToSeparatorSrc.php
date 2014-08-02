<?php

namespace KORD\Filtration\Word;

class UnderscoreToSeparatorSrc extends SeparatorToSeparator
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
        return '_';
    }

}
