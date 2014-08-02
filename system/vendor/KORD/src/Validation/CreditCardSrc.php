<?php

namespace KORD\Validation;

use KORD\Arr;
use KORD\Validation\CreditCard;
use KORD\Validation\Exception;

class CreditCardSrc extends RuleAbstract
{

    /**
     * Detected CCI list
     *
     * @var string
     */
    const AMERICAN_EXPRESS = 'American_Express';
    const UNIONPAY = 'Unionpay';
    const DINERS_CLUB = 'Diners_Club';
    const DINERS_CLUB_US = 'Diners_Club_US';
    const DISCOVER = 'Discover';
    const JCB = 'JCB';
    const LASER = 'Laser';
    const MAESTRO = 'Maestro';
    const MASTERCARD = 'Mastercard';
    const SOLO = 'Solo';
    const VISA = 'Visa';

    /**
     * List of CCV names
     *
     * @var array
     */
    protected $card_name = [
        0 => CreditCard::AMERICAN_EXPRESS,
        1 => CreditCard::DINERS_CLUB,
        2 => CreditCard::DINERS_CLUB_US,
        3 => CreditCard::DISCOVER,
        4 => CreditCard::JCB,
        5 => CreditCard::LASER,
        6 => CreditCard::MAESTRO,
        7 => CreditCard::MASTERCARD,
        8 => CreditCard::SOLO,
        9 => CreditCard::UNIONPAY,
        10 => CreditCard::VISA,
    ];

    /**
     * List of allowed CCV lengths
     *
     * @var array
     */
    protected $card_length = [
        CreditCard::AMERICAN_EXPRESS => [15],
        CreditCard::DINERS_CLUB => [14],
        CreditCard::DINERS_CLUB_US => [16],
        CreditCard::DISCOVER => [16],
        CreditCard::JCB => [16],
        CreditCard::LASER => [16, 17, 18, 19],
        CreditCard::MAESTRO => [12, 13, 14, 15, 16, 17, 18, 19],
        CreditCard::MASTERCARD => [16],
        CreditCard::SOLO => [16, 18, 19],
        CreditCard::UNIONPAY => [16, 17, 18, 19],
        CreditCard::VISA => [16],
    ];

    /**
     * List of accepted CCV provider tags
     *
     * @var array
     */
    protected $card_type = [
        CreditCard::AMERICAN_EXPRESS => ['34', '37'],
        CreditCard::DINERS_CLUB => ['300', '301', '302', '303', '304', '305', '36'],
        CreditCard::DINERS_CLUB_US => ['54', '55'],
        CreditCard::DISCOVER => ['6011', '622126', '622127', '622128', '622129', '62213',
            '62214', '62215', '62216', '62217', '62218', '62219',
            '6222', '6223', '6224', '6225', '6226', '6227', '6228',
            '62290', '62291', '622920', '622921', '622922', '622923',
            '622924', '622925', '644', '645', '646', '647', '648',
            '649', '65'],
        CreditCard::JCB => ['3528', '3529', '353', '354', '355', '356', '357', '358'],
        CreditCard::LASER => ['6304', '6706', '6771', '6709'],
        CreditCard::MAESTRO => ['5018', '5020', '5038', '6304', '6759', '6761', '6762', '6763',
            '6764', '6765', '6766'],
        CreditCard::MASTERCARD => ['51', '52', '53', '54', '55'],
        CreditCard::SOLO => ['6334', '6767'],
        CreditCard::UNIONPAY => ['622126', '622127', '622128', '622129', '62213', '62214',
            '62215', '62216', '62217', '62218', '62219', '6222', '6223',
            '6224', '6225', '6226', '6227', '6228', '62290', '62291',
            '622920', '622921', '622922', '622923', '622924', '622925'],
        CreditCard::VISA => ['4'],
    ];

    /**
     * Options for this validator
     *
     * @var array
     */
    protected $options = [
        'type' => [], // CCIs which are accepted by validation
        'service' => null, // Service callback for additional validation
    ];

    /**
     * Set filter options
     * 
     * @param  array|Traversable $options
     * @return self
     * @throws \KORD\Filtration\Exception
     */
    public function setOptions($options = [])
    {
        foreach ($options as $key => $value) {
            if (is_int($key)) {
                if (is_callable($value)) {
                    $this->setService($value);
                } else {
                    $this->addType($value);
                }
                unset($options[$key]);
            }
        }

        parent::setOptions($options);
    }

    /**
     * Returns a list of accepted CCIs
     *
     * @return array
     */
    public function getType()
    {
        return $this->options['type'];
    }

    /**
     * Sets CCIs which are accepted by validation
     *
     * @param  string|array $type Type to allow for validation
     * @return $this Provides a fluid interface
     */
    public function setType($type)
    {
        $this->options['type'] = [];
        return $this->addType($type);
    }

    /**
     * Adds a CCI to be accepted by validation
     *
     * @param  string|array $type Type to allow for validation
     * @return $this Provides a fluid interface
     */
    public function addType($type)
    {
        if (is_string($type)) {
            $type = [$type];
        }

        foreach ($type as $typ) {
            if (defined('\KORD\Validation\CreditCard::' . strtoupper($typ)) AND ! in_array($typ, $this->options['type'])) {
                $this->options['type'][] = $typ;
            }
        }

        if (empty($type)) {
            $this->options['type'] = array_keys($this->card_length);
        }

        return $this;
    }

    /**
     * Returns the actual set service
     *
     * @return callable
     */
    public function getService()
    {
        return $this->options['service'];
    }

    /**
     * Sets a new callback for service validation
     *
     * @param  callable $service
     * @return $this
     * @throws \KORD\Validation\Exception on invalid service callback
     */
    public function setService($service)
    {
        if (!is_callable($service)) {
            throw new Exception('Invalid callback given');
        }

        $this->options['service'] = $service;
        return $this;
    }

    /**
     * Returns true if and only if $value follows the Luhn algorithm (mod-10 checksum)
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->addError('creditcardInvalid');
            return false;
        }

        if (!ctype_digit($value)) {
            $this->addError('creditcardContent');
            return false;
        }

        $length = strlen($value);
        $types = $this->getType();
        $foundp = false;
        $foundl = false;
        foreach ($types as $type) {
            foreach ($this->card_type[$type] as $prefix) {
                if (substr($value, 0, strlen($prefix)) == $prefix) {
                    $foundp = true;
                    if (in_array($length, $this->card_length[$type])) {
                        $foundl = true;
                        break 2;
                    }
                }
            }
        }

        if ($foundp == false) {
            $this->addError('creditcardPrefix');
            return false;
        }

        if ($foundl == false) {
            $this->addError('creditcardLength');
            return false;
        }

        $sum = 0;
        $weight = 2;

        for ($i = $length - 2; $i >= 0; $i--) {
            $digit = $weight * $value[$i];
            $sum += floor($digit / 10) + $digit % 10;
            $weight = $weight % 2 + 1;
        }

        if ((10 - $sum % 10) % 10 != $value[$length - 1]) {
            $this->addError('creditcardChecksum');
            return false;
        }

        $service = $this->getService();
        if (!empty($service)) {
            try {
                $callback = new Callback($service);
                $callback->setCallbackParams([$this->getType()]);
                if (!$callback->isValid($value)) {
                    $this->addError('creditcardService');
                    return false;
                }
            } catch (\Exception $e) {
                $this->addError('creditcardServiceFailure');
                return false;
            }
        }

        return true;
    }

}
