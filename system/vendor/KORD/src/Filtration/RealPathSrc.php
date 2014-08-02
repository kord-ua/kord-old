<?php

namespace KORD\Filtration;

class RealPathSrc extends FilterAbstract
{

    /**
     * @var array $options
     */
    protected $options = [
        'exists' => true
    ];

    /**
     * Sets if the path has to exist
     * true when the path must exist
     * false when not existing paths can be given
     *
     * @param  bool $flag Path must exist
     * @return $this
     */
    public function setExists($flag = true)
    {
        $this->options['exists'] = (bool) $flag;
        return $this;
    }

    /**
     * Returns true if the filtered path must exist
     *
     * @return bool
     */
    public function getExists()
    {
        return $this->options['exists'];
    }

    /**
     * Defined by \KORD\Filtration\FilterInterface
     *
     * Returns realpath($value)
     *
     * If the value provided is non-scalar, the value will remain unfiltered
     *
     * @param  string $value
     * @return string|mixed
     */
    public function filter($value)
    {
        if(!is_string($value)){
            return $value;
        }
        
        $path = (string) $value;

        if ($this->options['exists']) {
            return realpath($path);
        }

        $realpath = @realpath($path);
        if ($realpath) {
            return $realpath;
        }

        $drive = '';
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $path = preg_replace('/[\\\\\/]/', DS, $path);
            if (preg_match('/([a-zA-Z]\:)(.*)/', $path, $matches)) {
                list(, $drive, $path) = $matches;
            } else {
                $cwd   = getcwd();
                $drive = substr($cwd, 0, 2);
                if (substr($path, 0, 1) != DS) {
                    $path = substr($cwd, 3) . DS . $path;
                }
            }
        } elseif (substr($path, 0, 1) != DS) {
            $path = getcwd() . DS . $path;
        }

        $stack = [];
        $parts = explode(DS, $path);
        foreach ($parts as $dir) {
            if (strlen($dir) AND $dir !== '.') {
                if ($dir == '..') {
                    array_pop($stack);
                } else {
                    array_push($stack, $dir);
                }
            }
        }

        return $drive . DS . implode(DS, $stack);
    }

}
