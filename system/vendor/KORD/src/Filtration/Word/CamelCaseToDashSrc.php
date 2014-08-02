<?php

namespace KORD\Filtration\Word;

class CamelCaseToDashSrc extends CamelCaseToSeparator
{
    
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
