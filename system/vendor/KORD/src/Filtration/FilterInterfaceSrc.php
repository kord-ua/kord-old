<?php

namespace KORD\Filtration;

interface FilterInterfaceSrc
{
    /**
     * Returns the result of filtering $value
     *
     * @param  mixed $value
     * @throws \KORD\Filtration\Exception If filtering $value is impossible
     * @return mixed
     */
    public function filter($value);
}
