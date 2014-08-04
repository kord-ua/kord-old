<?php

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace KORD\Filtration\Word;

use KORD\Filtration\FilterAbstract;
use KORD\Filtration\Exception;

abstract class WordFilterAbstractSrc extends FilterAbstract
{
    
    /**
     * Filter options
     *
     * @var array
     */
    protected $options = [
        'search_separator' => null,
        'replacement_separator' => null
    ];
    
    /**
     * Sets a new separator to search for
     *
     * @param  string $separator Separator to search for
     * @return $this
     */
    public function setSearchSeparator($separator)
    {
        if (!is_string($separator)) {
            throw new Exception('"' . $separator . '" is not a valid separator.');
        }
        
        $this->options['search_separator'] = $separator;
        return $this;
    }

    /**
     * Returns the actual set separator to search for
     *
     * @return string
     */
    public function getSearchSeparator()
    {
        if (!isset($this->options['search_separator']) OR !is_string($this->options['search_separator'])) {
            throw new Exception('A search separator is not set or is not valid!!');
        }
        
        return $this->options['search_separator'];
    }

    /**
     * Sets a new separator which replaces the searched one
     *
     * @param  string $separator Separator which replaces the searched one
     * @return $this
     */
    public function setReplacementSeparator($separator)
    {
        if (!is_string($separator)) {
            throw new Exception('"' . $separator . '" is not a valid separator.');
        }
        
        $this->options['replacement_separator'] = $separator;
        return $this;
    }

    /**
     * Returns the actual set separator which replaces the searched one
     *
     * @return string
     */
    public function getReplacementSeparator()
    {
        if (!isset($this->options['replacement_separator']) OR !is_string($this->options['replacement_separator'])) {
            throw new Exception('A replacement separator is not set or is not valid!!');
        }
        
        return $this->options['replacement_separator'];
    }
    
}
