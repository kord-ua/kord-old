<?php

namespace KORD\Filtration;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
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
