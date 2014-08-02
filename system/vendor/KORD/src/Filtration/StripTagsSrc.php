<?php

namespace KORD\Filtration;

class StripTagsSrc extends FilterAbstract
{
    /**
     * Filter options
     * 
     * @var array
     */
    protected $options = [
        'tags_allowed' => [],
        'attributes_allowed' => []
    ];

    /**
     * Returns the tags_allowed option
     *
     * @return array
     */
    public function getTagsAllowed()
    {
        return $this->options['tags_allowed'];
    }

    /**
     * Sets the tags_allowed option
     *
     * @param  array|string $tags_allowed
     * @return $this Provides a fluent interface
     */
    public function setTagsAllowed($tags_allowed)
    {
        if (!is_array($tags_allowed)) {
            $tags_allowed = [$tags_allowed];
        }

        foreach ($tags_allowed as $index => $element) {
            // If the tag was provided without attributes
            if (is_int($index) AND is_string($element)) {
                // Canonicalize the tag name
                $tag_name = strtolower($element);
                // Store the tag as allowed with no attributes
                $this->options['tags_allowed'][$tag_name] = [];
            }
            // Otherwise, if a tag was provided with attributes
            elseif (is_string($index) AND (is_array($element) OR is_string($element))) {
                // Canonicalize the tag name
                $tag_name = strtolower($index);
                // Canonicalize the attributes
                if (is_string($element)) {
                    $element = [$element];
                }
                // Store the tag as allowed with the provided attributes
                $this->options['tags_allowed'][$tag_name] = [];
                foreach ($element as $attribute) {
                    if (is_string($attribute)) {
                        // Canonicalize the attribute name
                        $attribute_name = strtolower($attribute);
                        $this->options['tags_allowed'][$tag_name][$attribute_name] = null;
                    }
                }
            }
        }

        return $this;
    }

    /**
     * Returns the attributes_allowed option
     *
     * @return array
     */
    public function getAttributesAllowed()
    {
        return $this->options['attributes_allowed'];
    }

    /**
     * Sets the attributes_allowed option
     *
     * @param  array|string $attributes_allowed
     * @return $this Provides a fluent interface
     */
    public function setAttributesAllowed($attributes_allowed)
    {
        if (!is_array($attributes_allowed)) {
            $attributes_allowed = [$attributes_allowed];
        }

        // Store each attribute as allowed
        foreach ($attributes_allowed as $attribute) {
            if (is_string($attribute)) {
                // Canonicalize the attribute name
                $attribute_name = strtolower($attribute);
                $this->options['attributes_allowed'][$attribute_name] = null;
            }
        }

        return $this;
    }

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * If the value provided is non-scalar, the value will remain unfiltered
     *
     * @todo   improve docblock descriptions
     * @todo   use DOMDocument, also to find unclosed tags
     * @param  string $value
     * @return string|mixed
     */
    public function filter($value)
    {
        if (!is_scalar($value)) {
            return $value;
        }
        $value = (string) $value;

        // Strip HTML comments first
        while (strpos($value, '<!--') !== false) {
            $pos   = strrpos($value, '<!--');
            $start = substr($value, 0, $pos);
            $value = substr($value, $pos);

            // If there is no comment closing tag, strip whole text
            if (!preg_match('/--\s*>/s', $value)) {
                $value = '';
            } else {
                $value = preg_replace('/<(?:!(?:--[\s\S]*?--\s*)?(>))/s', '',  $value);
            }

            $value = $start . $value;
        }

        // Initialize accumulator for filtered data
        $data_filtered = '';
        // Parse the input data iteratively as regular pre-tag text followed by a
        // tag; either may be empty strings
        preg_match_all('/([^<]*)(<?[^>]*>?)/', (string) $value, $matches);

        // Iterate over each set of matches
        foreach ($matches[1] as $index => $pre_tag) {
            // If the pre-tag text is non-empty, strip any ">" characters from it
            if (strlen($pre_tag)) {
                $pre_tag = str_replace('>', '', $pre_tag);
            }
            // If a tag exists in this match, then filter the tag
            $tag = $matches[2][$index];
            if (strlen($tag)) {
                $tag_filtered = $this->filterTag($tag);
            } else {
                $tag_filtered = '';
            }
            // Add the filtered pre-tag text and filtered tag to the data buffer
            $data_filtered .= $pre_tag . $tag_filtered;
        }

        // Return the filtered data
        return $data_filtered;
    }

    /**
     * Filters a single tag against the current option settings
     *
     * @param  string $tag
     * @return string
     */
    protected function filterTag($tag)
    {
        // Parse the tag into:
        // 1. a starting delimiter (mandatory)
        // 2. a tag name (if available)
        // 3. a string of attributes (if available)
        // 4. an ending delimiter (if available)
        $is_match = preg_match('~(</?)(\w*)((/(?!>)|[^/>])*)(/?>)~', $tag, $matches);

        // If the tag does not match, then strip the tag entirely
        if (!$is_match) {
            return '';
        }

        // Save the matches to more meaningfully named variables
        $tag_start      = $matches[1];
        $tag_name       = strtolower($matches[2]);
        $tag_attributes = $matches[3];
        $tag_end        = $matches[5];

        // If the tag is not an allowed tag, then remove the tag entirely
        if (!isset($this->options['tags_allowed'][$tag_name])) {
            return '';
        }

        // Trim the attribute string of whitespace at the ends
        $tag_attributes = trim($tag_attributes);

        // If there are non-whitespace characters in the attribute string
        if (strlen($tag_attributes)) {
            // Parse iteratively for well-formed attributes
            preg_match_all('/([\w-]+)\s*=\s*(?:(")(.*?)"|(\')(.*?)\')/s', $tag_attributes, $matches);

            // Initialize valid attribute accumulator
            $tag_attributes = '';

            // Iterate over each matched attribute
            foreach ($matches[1] as $index => $attribute_name) {
                $attribute_name      = strtolower($attribute_name);
                $attribute_delimiter = empty($matches[2][$index]) ? $matches[4][$index] : $matches[2][$index];
                $attribute_value     = (strlen($matches[3][$index]) == 0) ? $matches[5][$index] : $matches[3][$index];

                // If the attribute is not allowed, then remove it entirely
                if (!array_key_exists($attribute_name, $this->options['tags_allowed'][$tag_name])
                    AND !array_key_exists($attribute_name, $this->options['attributes_allowed'])) {
                    continue;
                }
                // Add the attribute to the accumulator
                $tag_attributes .= " $attribute_name=" . $attribute_delimiter
                                . $attribute_value . $attribute_delimiter;
            }
        }

        // Reconstruct tags ending with "/>" as backwards-compatible XHTML tag
        if (strpos($tag_end, '/') !== false) {
            $tag_end = " $tag_end";
        }

        // Return the filtered tag
        return $tag_start . $tag_name . $tag_attributes . $tag_end;
    }
}
