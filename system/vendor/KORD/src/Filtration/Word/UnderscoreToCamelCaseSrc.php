<?php

namespace KORD\Filtration\Word;

class UnderscoreToCamelCaseSrc extends SeparatorToCamelCase
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

}
