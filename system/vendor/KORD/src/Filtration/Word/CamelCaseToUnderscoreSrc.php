<?php

namespace KORD\Filtration\Word;

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
