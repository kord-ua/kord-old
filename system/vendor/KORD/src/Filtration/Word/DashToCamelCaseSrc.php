<?php

namespace KORD\Filtration\Word;

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
