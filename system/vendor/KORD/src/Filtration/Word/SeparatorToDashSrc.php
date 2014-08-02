<?php

namespace KORD\Filtration\Word;

class SeparatorToDashSrc extends SeparatorToSeparator
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
