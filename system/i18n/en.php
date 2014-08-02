<?php

defined('SYSPATH') or die('No direct script access.');
/**
 * English sample translations
 * 
 * @package    I18n_Plural
 * @author     Korney Czukowski
 * @copyright  (c) 2011 Korney Czukowski
 * @license    MIT License
 */
return [
    'general' => [
        'yes' => 'yes',
        'no' => 'no'
    ],
    // Plural test
    ':count files' => [
        'one' => ':count file',
        'other' => ':count files',
    ],
    // Date/time
    'date' => [
        'date' => [
            // On Sunday, December 10 2007
            'long' => '%N, %B &d %Y',
            // 07/03/2011
            'short' => '%m/%d/%Y',
        ],
        'months' => [
            'abbr' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'other' => ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        ],
        'days' => [
            'abbr' => ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            'acc' => ['On Sunday', 'On Monday', 'On Tuesday', 'On Wednesday', 'On Thursday', 'On Friday', 'On Saturday'],
            'other' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        ],
        // Culture's date order: MM/DD/YYYY
        'order' => ['month', 'date', 'year'],
        'time' => [
            // 12:01:59
            'long' => '%H:%M:%S',
            // 12:01am
            'short' => '%I:%M%p',
        ],
        'am' => 'AM',
        'pm' => 'PM',
        'less_than_minute_ago' => 'less than a minute ago',
        'minute_ago' => [
            'one' => 'about a minute ago',
            'other' => '{delta} minutes ago',
        ],
        'hour_ago' => [
            'one' => 'about an hour ago',
            'other' => 'about {delta} hours ago',
        ],
        'day_ago' => [
            'one' => '1 day ago',
            'other' => '{delta} days ago',
        ],
        'week_ago' => [
            'one' => '1 week ago',
            'other' => '{delta} weeks ago',
        ],
        'month_ago' => [
            'one' => '1 month ago',
            'other' => '{delta} months ago',
        ],
        'year_ago' => [
            'one' => '1 year ago',
            'other' => '{delta} years ago',
        ],
        'less_than_minute_until' => 'less than a minute from now',
        'minute_until' => [
            'one' => 'about a minute from now',
            'other' => '{delta} minutes from now',
        ],
        'hour_until' => [
            'one' => 'about an hour from now',
            'other' => 'about {delta} hours from now',
        ],
        'day_until' => [
            'one' => '1 day from now',
            'other' => '{delta} days from now',
        ],
        'week_until' => [
            'one' => '1 week from now',
            'other' => '{delta} weeks from now',
        ],
        'month_until' => [
            'one' => '1 month from now',
            'other' => '{delta} months from now',
        ],
        'year_until' => [
            'one' => '1 year from now',
            'other' => '{delta} years from now',
        ],
        'never' => 'never',
    ],
    'valid' => [
        // AlNum
        'alnumInvalid' => "Invalid type given. String, integer or float expected",
        'notAlnum' => "':field' contains characters which are non alphabetic and no digits",
        // Alpha
        'alphaInvalid' => "Invalid type given. String expected",
        'notAlpha' => "':field' contains non alphabetic characters",
        // Barcode
        'barcodeInvalid' => "Invalid type given. String expected",
        'barcodeInvalidValue' => "':field' failed barcode validation",
        'barcodeFailed' => "':field' failed checksum validation",
        'barcodeInvalidChars' => "':field' contains invalid characters",
        'barcodeInvalidLength' => [
            'one' => "':field' should have a length of one character",
            'other' => "':field' should have a length of :length characters"
        ],
        // Callback
        'callbackInvalid' => "An exception has been raised within the callback",
        'callbackInvalidValue' => ":field is not valid",
        // CreditCard
        'creditcardInvalid' => "Invalid type given. String expected",
        'creditcardContent' => "':field' must contain only digits",
        'creditcardPrefix' => "':field' is not from an allowed institute",
        'creditcardLength' => "':field' contains an invalid amount of digits",
        'creditcardChecksum' => "':field' seems to contain an invalid checksum",
        'creditcardService' => "':field' seems to be an invalid credit card number",
        'creditcardServiceFailure' => "An exception has been raised while validating ':field'",
        // Date
        'dateInvalidDate' => "':field' does not appear to be a valid date",
        'dateInvalid' => "Invalid type given. String, integer, array or DateTime expected",
        'dateFalseFormat' => "':field' does not fit the date format ':format'",
        // Digits
        'digitsInvalid' => 'Invalid type given. String, integer or float expected',
        'notDigits' => ':field must contain only digits',
        // Email
        'emailInvalid' => "Invalid type given. String expected",
        'emailDotAtom' => "':localpart' can not be matched against dot-atom format",
        'emailQuotedString' => "':localpart' can not be matched against quoted-string format",
        'emailInvalidLocalPart' => "':localpart' is not a valid local part for the email address",
        'emailInvalidMxRecord' => "':hostname' does not appear to have any valid MX or A records for the email address",
        'emailInvalidSegment' => "':hostname' is not in a routable network segment. The email address should not be resolved from public network",
        'emailInvalidHostname' => "':hostname' is not a valid hostname for the email address",
        'emailInvalidFormat' => "':field' is not a valid email address. Use the basic format local-part@hostname",
        'emailLengthExceeded' => "':field' exceeds the allowed length",
        // Float
        'floatInvalid' => "Invalid type given. String, integer or float expected",
        'notFloat' => "':field' does not appear to be a float",
        // Hex
        'hexInvalid' => "Invalid type given. String or integer expected",
        'notHex' => "':field' contains non-hexadecimal characters",
        // Hostname
        'hostnameCannotDecodePunycode' => "':field' appears to be a DNS hostname but the given punycode notation cannot be decoded",
        'hostnameDashCharacter' => "':field' appears to be a DNS hostname but contains a dash in an invalid position",
        'hostnameInvalid' => "Invalid type given. String expected",
        'hostnameInvalidHostname' => "':field' does not match the expected structure for a DNS hostname",
        'hostnameInvalidHostnameSchema' => "':field' appears to be a DNS hostname but cannot match against hostname schema for TLD ':tld'",
        'hostnameInvalidLocalName' => "':field' does not appear to be a valid local network name",
        'hostnameInvalidUri' => "':field' does not appear to be a valid URI hostname",
        'hostnameIpAddressNotAllowed' => "':field' appears to be an IP address, but IP addresses are not allowed",
        'hostnameLocalNameNotAllowed' => "':field' appears to be a local network name but local network names are not allowed",
        'hostnameUndecipherableTld' => "':field' appears to be a DNS hostname but cannot extract TLD part",
        'hostnameUnknownTld' => "':field' appears to be a DNS hostname but cannot match TLD against known list",
        // IBAN
        'ibanCheckFailed' => "':field' has failed the IBAN check",
        'ibanFalseFormat' => "':field' has a false IBAN format",
        'ibanNotSupported' => "Unknown country within the IBAN",
        'ibanSepaNotSupported' => "Countries outside the Single Euro Payments Area (SEPA) are not supported",
        // Identical
        'missingToken' => "No token was provided to match against",
        'notSame' => "The two given tokens do not match",
        // InArray
        'notInArray' => "':field' was not found in the haystack",
        // Int
        'intInvalid' => "Invalid type given. String or integer expected",
        'notInt' => "The input does not appear to be an integer",
        // IP
        'ipInvalid' => "Invalid type given. String expected",
        'notIpAddress' => "':field' does not appear to be a valid IP address",
        // ISBN
        'isbnInvalid' => "Invalid type given. String or integer expected",
        'isbnNoIsbn' => "':field' is not a valid ISBN number",
        // NotEmpty
        'isEmpty' => "Value is required and can't be empty",
        'notEmptyInvalid' => "Invalid type given. String, integer, float, boolean or array expected",
        // PostCode
        'postcodeInvalid' => "Invalid type given. String or integer expected",
        'postcodeNoMatch' => "':field' does not appear to be a postal code",
        'postcodeServiceFailure' => "An exception has been raised while validating the input",
        // Regex
        'regexErrorous' => "There was an internal error while using the pattern ':pattern'",
        'regexInvalid' => "Invalid type given. String, integer or float expected",
        'regexNotMatch' => "':field' does not match against any pattern",
        // Range
        'notGreaterThan' => "':field' is not greater than :min",
        'notGreaterThanInclusive' => "':field' is not greater or equal than :min",
        'notLessThan' => "':field' is not less than :max",
        'notLessThanInclusive' => "':field' is not less or equal than :max",
        'stepInvalid' => "':field' is not a valid step",
        'typeInvalid' => "Invalid value given. Scalar expected",
        // StringLength
        'stringLengthInvalid' => "Invalid type given. String expected",
        'stringLengthTooLong' => "':field' is more than :max characters long",
        'stringLengthTooShort' => "':field' is less than :min characters long",
        // OLD
        'decimal' => [
            'one' => ':field must be a decimal with one place',
            'other' => ':field must be a decimal with :param2 places',
        ],
        'exact_length' => [
            'one' => ':field must be exactly one character long',
            'other' => ':field must be exactly :param2 characters long',
        ],
        'max_length' => [
            'other' => ':field must be less than :param2 characters long',
        ],
        'min_length' => [
            'one' => ':field must be at least one character long',
            'other' => ':field must be at least :param2 characters long',
        ],
    ],
];
