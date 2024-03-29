<?php

namespace KORD\Filtration;

use KORD\Core;
use KORD\Helper\UTF8;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class AlnumSrc extends FilterAbstract
{

    /**
     * Filter options
     * 
     * @var array
     */
    protected $options = [
        'allow_white_space' => false,
        'lang' => null
    ];

    /**
     * Sets the allow_white_space option
     *
     * @param  bool $flag
     * @return $this Provides a fluent interface
     */
    public function setAllowWhiteSpace($flag)
    {
        $this->options['allow_white_space'] = (bool) $flag;
        return $this;
    }

    /**
     * Whether white space is allowed
     *
     * @return bool
     */
    public function getAllowWhiteSpace()
    {
        return $this->options['allow_white_space'];
    }

    /**
     * Sets the lang option
     *
     * @param  string|null $lang
     * @return $this
     */
    public function setLang($lang)
    {
        $this->options['lang'] = $lang;
        return $this;
    }

    /**
     * Returns the lang option
     *
     * @return string
     */
    public function getLang()
    {
        if (!isset($this->options['lang'])) {
            $this->options['lang'] = Core::$i18n->lang();
        }
        return $this->options['lang'];
    }

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns $value as string with all non-alphanumeric characters removed
     *
     * @param  string|array $value
     * @return string|array
     */
    public function filter($value)
    {
        if (!is_scalar($value) AND ! is_array($value)) {
            return $value;
        }

        $white_space = $this->getAllowWhiteSpace() ? '\s' : '';

        $lang_parts = explode('-', $this->getLang());
        $language = $lang_parts[0];

        if (!UTF8::unicodeEnabled()) {
            // POSIX named classes are not supported, use alternative a-zA-Z0-9 match
            $pattern = '/[^a-zA-Z0-9' . $white_space . ']/';
        } elseif ($language == 'ja' OR $language == 'ko' OR $language == 'zh') {
            // Use english alphabet
            $pattern = '/[^a-zA-Z0-9' . $white_space . ']/u';
        } else {
            // Use native language alphabet
            $pattern = '/[^\p{L}\p{N}' . $white_space . ']/u';
        }

        return preg_replace($pattern, '', (string) $value);
    }

}
