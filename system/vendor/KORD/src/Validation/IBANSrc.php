<?php

namespace KORD\Validation;

use KORD\Validation\Exception;
use KORD\Validation\IBAN;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @copyright  (c) 2014 Andriy Strepetov
 */
class IBANSrc extends RuleAbstract
{

    /**
     * Default options to set for the validator
     *
     * @var mixed
     */
    protected $options = [
        'country_code' => null,
        'allow_non_sepa' => true
    ];
    
    /**
     * The SEPA country codes
     *
     * @var array<ISO 3166-1>
     */
    protected static $sepa_countries = [
        'AT', 'BE', 'BG', 'CY', 'CZ', 'DK', 'FO', 'GL', 'EE', 'FI', 'FR', 'DE',
        'GI', 'GR', 'HU', 'IS', 'IE', 'IT', 'LV', 'LI', 'LT', 'LU', 'MT', 'MC',
        'NL', 'NO', 'PL', 'PT', 'RO', 'SK', 'SI', 'ES', 'SE', 'CH', 'GB'
    ];

    /**
     * IBAN regexes by country code
     *
     * @var array
     */
    protected static $iban_regex = [
        'AD' => 'AD[0-9]{2}[0-9]{4}[0-9]{4}[A-Z0-9]{12}',
        'AE' => 'AE[0-9]{2}[0-9]{3}[0-9]{16}',
        'AL' => 'AL[0-9]{2}[0-9]{8}[A-Z0-9]{16}',
        'AT' => 'AT[0-9]{2}[0-9]{5}[0-9]{11}',
        'AZ' => 'AZ[0-9]{2}[A-Z]{4}[A-Z0-9]{20}',
        'BA' => 'BA[0-9]{2}[0-9]{3}[0-9]{3}[0-9]{8}[0-9]{2}',
        'BE' => 'BE[0-9]{2}[0-9]{3}[0-9]{7}[0-9]{2}',
        'BG' => 'BG[0-9]{2}[A-Z]{4}[0-9]{4}[0-9]{2}[A-Z0-9]{8}',
        'BH' => 'BH[0-9]{2}[A-Z]{4}[A-Z0-9]{14}',
        'BR' => 'BR[0-9]{2}[0-9]{8}[0-9]{5}[0-9]{10}[A-Z][A-Z0-9]',
        'CH' => 'CH[0-9]{2}[0-9]{5}[A-Z0-9]{12}',
        'CR' => 'CR[0-9]{2}[0-9]{3}[0-9]{14}',
        'CY' => 'CY[0-9]{2}[0-9]{3}[0-9]{5}[A-Z0-9]{16}',
        'CZ' => 'CZ[0-9]{2}[0-9]{20}',
        'DE' => 'DE[0-9]{2}[0-9]{8}[0-9]{10}',
        'DO' => 'DO[0-9]{2}[A-Z0-9]{4}[0-9]{20}',
        'DK' => 'DK[0-9]{2}[0-9]{14}',
        'EE' => 'EE[0-9]{2}[0-9]{2}[0-9]{2}[0-9]{11}[0-9]{1}',
        'ES' => 'ES[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{1}[0-9]{1}[0-9]{10}',
        'FI' => 'FI[0-9]{2}[0-9]{6}[0-9]{7}[0-9]{1}',
        'FO' => 'FO[0-9]{2}[0-9]{4}[0-9]{9}[0-9]{1}',
        'FR' => 'FR[0-9]{2}[0-9]{5}[0-9]{5}[A-Z0-9]{11}[0-9]{2}',
        'GB' => 'GB[0-9]{2}[A-Z]{4}[0-9]{6}[0-9]{8}',
        'GE' => 'GE[0-9]{2}[A-Z]{2}[0-9]{16}',
        'GI' => 'GI[0-9]{2}[A-Z]{4}[A-Z0-9]{15}',
        'GL' => 'GL[0-9]{2}[0-9]{4}[0-9]{9}[0-9]{1}',
        'GR' => 'GR[0-9]{2}[0-9]{3}[0-9]{4}[A-Z0-9]{16}',
        'GT' => 'GT[0-9]{2}[A-Z0-9]{4}[A-Z0-9]{20}',
        'HR' => 'HR[0-9]{2}[0-9]{7}[0-9]{10}',
        'HU' => 'HU[0-9]{2}[0-9]{3}[0-9]{4}[0-9]{1}[0-9]{15}[0-9]{1}',
        'IE' => 'IE[0-9]{2}[A-Z]{4}[0-9]{6}[0-9]{8}',
        'IL' => 'IL[0-9]{2}[0-9]{3}[0-9]{3}[0-9]{13}',
        'IS' => 'IS[0-9]{2}[0-9]{4}[0-9]{2}[0-9]{6}[0-9]{10}',
        'IT' => 'IT[0-9]{2}[A-Z]{1}[0-9]{5}[0-9]{5}[A-Z0-9]{12}',
        'KW' => 'KW[0-9]{2}[A-Z]{4}[0-9]{22}',
        'KZ' => 'KZ[0-9]{2}[0-9]{3}[A-Z0-9]{13}',
        'LB' => 'LB[0-9]{2}[0-9]{4}[A-Z0-9]{20}',
        'LI' => 'LI[0-9]{2}[0-9]{5}[A-Z0-9]{12}',
        'LT' => 'LT[0-9]{2}[0-9]{5}[0-9]{11}',
        'LU' => 'LU[0-9]{2}[0-9]{3}[A-Z0-9]{13}',
        'LV' => 'LV[0-9]{2}[A-Z]{4}[A-Z0-9]{13}',
        'MC' => 'MC[0-9]{2}[0-9]{5}[0-9]{5}[A-Z0-9]{11}[0-9]{2}',
        'MD' => 'MD[0-9]{2}[A-Z0-9]{20}',
        'ME' => 'ME[0-9]{2}[0-9]{3}[0-9]{13}[0-9]{2}',
        'MK' => 'MK[0-9]{2}[0-9]{3}[A-Z0-9]{10}[0-9]{2}',
        'MR' => 'MR13[0-9]{5}[0-9]{5}[0-9]{11}[0-9]{2}',
        'MT' => 'MT[0-9]{2}[A-Z]{4}[0-9]{5}[A-Z0-9]{18}',
        'MU' => 'MU[0-9]{2}[A-Z]{4}[0-9]{2}[0-9]{2}[0-9]{12}[0-9]{3}[A-Z]{3}',
        'NL' => 'NL[0-9]{2}[A-Z]{4}[0-9]{10}',
        'NO' => 'NO[0-9]{2}[0-9]{4}[0-9]{6}[0-9]{1}',
        'PK' => 'PK[0-9]{2}[A-Z]{4}[A-Z0-9]{16}',
        'PL' => 'PL[0-9]{2}[0-9]{8}[0-9]{16}',
        'PS' => 'PS[0-9]{2}[A-Z]{4}[A-Z0-9]{21}',
        'PT' => 'PT[0-9]{2}[0-9]{4}[0-9]{4}[0-9]{11}[0-9]{2}',
        'RO' => 'RO[0-9]{2}[A-Z]{4}[A-Z0-9]{16}',
        'RS' => 'RS[0-9]{2}[0-9]{3}[0-9]{13}[0-9]{2}',
        'SA' => 'SA[0-9]{2}[0-9]{2}[A-Z0-9]{18}',
        'SE' => 'SE[0-9]{2}[0-9]{3}[0-9]{16}[0-9]{1}',
        'SI' => 'SI[0-9]{2}[0-9]{5}[0-9]{8}[0-9]{2}',
        'SK' => 'SK[0-9]{2}[0-9]{4}[0-9]{6}[0-9]{10}',
        'SM' => 'SM[0-9]{2}[A-Z]{1}[0-9]{5}[0-9]{5}[A-Z0-9]{12}',
        'TN' => 'TN59[0-9]{2}[0-9]{3}[0-9]{13}[0-9]{2}',
        'TR' => 'TR[0-9]{2}[0-9]{5}[A-Z0-9]{1}[A-Z0-9]{16}',
        'VG' => 'VG[0-9]{2}[A-Z]{4}[0-9]{16}',
    ];
    
    /**
     * Returns the optional country code by ISO 3166-1
     *
     * @return string|null
     */
    public function getCountryCode()
    {
        return $this->options['country_code'];
    }

    /**
     * Sets an optional country code by ISO 3166-1
     *
     * @param  string|null $country_code
     * @return $this provides a fluent interface
     * @throws \KORD\Validation\Exception
     */
    public function setCountryCode($country_code = null)
    {
        if ($country_code !== null) {
            $country_code = (string) $country_code;

            if (!isset(IBAN::$iban_regex[$country_code])) {
                throw new Exception(
                    "Country code '{$country_code}' invalid by ISO 3166-1 or not supported"
                );
            }
        }

        $this->options['country_code'] = $country_code;
        return $this;
    }

    /**
     * Returns the optional allow non-sepa countries setting
     *
     * @return bool
     */
    public function allowNonSepa()
    {
        return $this->options['allow_non_sepa'];
    }

    /**
     * Sets the optional allow non-sepa countries setting
     *
     * @param  bool $allow_non_sepa
     * @return $this provides a fluent interface
     */
    public function setAllowNonSepa($allow_non_sepa)
    {
        $this->options['allow_non_sepa'] = (bool) $allow_non_sepa;
        return $this;
    }
    
    /**
     * Returns true if $value is a valid IBAN
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->addError('ibanFalseFormat');
            return false;
        }

        $value = str_replace(' ', '', strtoupper($value));

        $country_code = $this->getCountryCode();
        if ($country_code === null) {
            $country_code = substr($value, 0, 2);
        }

        if (!array_key_exists($country_code, IBAN::$iban_regex)) {
            $this->addError('ibanNotSupported');
            return false;
        }

        if (!$this->allowNonSepa() AND !in_array($country_code, IBAN::$sepa_countries)) {
            $this->addError('ibanSepaNotSupported');
            return false;
        }

        if (!preg_match('/^' . IBAN::$iban_regex[$country_code] . '$/', $value)) {
            $this->addError('ibanFalseFormat');
            return false;
        }

        $format = substr($value, 4) . substr($value, 0, 4);
        $format = str_replace(
            ['A',  'B',  'C',  'D',  'E',  'F',  'G',  'H',  'I',  'J',  'K',  'L',  'M',
            'N',  'O',  'P',  'Q',  'R',  'S',  'T',  'U',  'V',  'W',  'X',  'Y',  'Z'],
            ['10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22',
            '23', '24', '25', '26', '27', '28', '29', '30', '31', '32', '33', '34', '35'],
            $format
        );

        $temp = intval(substr($format, 0, 1));
        $len  = strlen($format);
        for ($x = 1; $x < $len; ++$x) {
            $temp *= 10;
            $temp += intval(substr($format, $x, 1));
            $temp %= 97;
        }

        if ($temp != 1) {
            $this->addError('ibanCheckFailed');
            return false;
        }

        return true;
    }

}
