<?php

namespace KORD\Validation;

use KORD\Validation\Exception;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class BarcodeSrc extends RuleAbstract
{

    protected $options = [
        'adapters' => null, // Barcode adapters \KORD\Validation\Barcode\AdapterAbstract
    ];

    /**
     * Returns the set adapters
     *
     * @return Barcode\AbstractAdapter
     */
    public function getAdapters()
    {
        if ($this->options['adapters'] === null) {
            $this->setAdapters('Ean13');
        }

        return $this->options['adapters'];
    }

    /**
     * Sets barcode adapters
     *
     * @param  string|Barcode\AdapterAbstract|array $adapters Barcode adapters to use
     * @param  array  $options Options for this adapter
     * @return $this
     * @throws \KORD\Validation\Exception
     */
    public function setAdapters($adapters)
    {
        if (!is_array($adapters)) {
            $adapters = [$adapters];
        }

        foreach ($adapters as $adapter) {
            if (is_string($adapter)) {
                $adapter_class = 'KORD\\Validation\\Barcode\\' . ucfirst(strtolower($adapter));

                if (!class_exists($adapter_class)) {
                    throw new Exception('Barcode adapter matching "' . $adapter_class . '" not found');
                }

                $adapter = $this->options['adapters'][] = new $adapter_class();
            }

            if (!$adapter instanceof Barcode\AdapterInterface) {
                throw new Exception(
                "Adapter $adapter does not implement KORD\\Validation\\Barcode\\AdapterInterface"
                );
            }
        }

        return $this;
    }

    /**
     * Defined by \KORD\Validation\RuleInterface
     *
     * Returns true if and only if $value contains a valid barcode
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        $valid = false;
        
        foreach ($this->getAdapters() as $adapter) {
            if ($adapter->isValid($value)) {
                $valid = true;
            }
        }
            
        if (!$valid) {
            $this->addError('barcodeInvalidValue');
            return false;
        }

        return $valid;
    }

}
