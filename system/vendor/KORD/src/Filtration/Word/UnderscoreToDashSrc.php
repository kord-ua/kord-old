<?php

namespace KORD\Filtration\Word;

class UnderscoreToDashSrc extends SeparatorToSeparator
{

    /**
     * Returns the actual set separator to search for
     *
     * @return string
     */
    public function getSearchSeparator()
    {
        return '_';
    }
    
    /**
     * Returns the actual set separator which replaces the searched one
     *
     * @return string
     */
    public function getReplacementSeparator()
    {
        return '-';
    }

}
