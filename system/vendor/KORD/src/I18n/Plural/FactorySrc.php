<?php

/**
 * I18n Plural rules factory
 */

namespace KORD\I18n\Plural;

class FactorySrc
{

    /**
     * Chooses inflection class to use according to CLDR plural rules
     * 
     * @param   string  $prefix
     * @return  \KORD\I18n\Plural\PluralInterface
     */
    public function createRules($prefix)
    {
        if ($prefix === 'pl') {
            return new Polish;
        } elseif (in_array($prefix, ['cs', 'sk'], true)) {
            return new Czech;
        } elseif (in_array($prefix, ['fr', 'ff', 'kab'], true)) {
            return new French;
        } elseif (in_array($prefix, ['ru', 'sr', 'uk', 'sh', 'be', 'hr', 'bs'], true)) {
            return new Balkan;
        } elseif (in_array($prefix, [
                    'en', 'ny', 'nr', 'no', 'om', 'os', 'ps', 'pa', 'nn', 'or', 'nl', 'lg', 'lb', 'ky', 'ml', 'mr',
                    'ne', 'nd', 'nb', 'pt', 'rm', 'ts', 'tn', 'tk', 'ur', 'vo', 'zu', 'xh', 've', 'te', 'ta', 'sq',
                    'so', 'sn', 'ss', 'st', 'sw', 'sv', 'ku', 'mn', 'et', 'eo', 'el', 'eu', 'fi', 'fy', 'fo', 'ee',
                    'dv', 'bg', 'af', 'bn', 'ca', 'de', 'da', 'gl', 'es', 'it', 'is', 'ks', 'ha', 'kk', 'kl', 'gu',
                    'brx', 'mas', 'teo', 'chr', 'cgg', 'tig', 'wae', 'xog', 'ast', 'vun', 'bem', 'syr', 'bez', 'asa',
                    'rof', 'ksb', 'rwk', 'haw', 'pap', 'gsw', 'fur', 'saq', 'seh', 'nyn', 'kcg', 'ssy', 'kaj', 'jmc',
                    'nah', 'ckb'], true)) {
            return new One;
        } elseif ($prefix === 'mt') {
            return new Maltese;
        } elseif ($prefix === 'gv') {
            return new Manx;
        } elseif ($prefix === 'sl') {
            return new Slovenian;
        } elseif ($prefix === 'cy') {
            return new Welsh;
        } elseif ($prefix === 'ar') {
            return new Arabic;
        } elseif ($prefix === 'shi') {
            return new Tachelhit;
        } elseif ($prefix === 'tzm') {
            return new Tamazight;
        } elseif ($prefix === 'mk') {
            return new Macedonian;
        } elseif ($prefix === 'lt') {
            return new Lithuanian;
        } elseif ($prefix === 'he') {
            return new Hebrew;
        } elseif ($prefix === 'gd') {
            return new Gaelic;
        } elseif ($prefix === 'ga') {
            return new Irish;
        } elseif ($prefix === 'lag') {
            return new Langi;
        } elseif ($prefix === 'lv') {
            return new Latvian;
        } elseif ($prefix === 'br') {
            return new Breton;
        } elseif ($prefix === 'ksh') {
            return new Colognian;
        } elseif (in_array($prefix, ['mo', 'ro'], true)) {
            return new Romanian;
        } elseif (in_array($prefix, [
                    'se', 'kw', 'iu', 'smn', 'sms', 'smj', 'sma', 'naq', 'smi'], true)) {
            return new Two;
        } elseif (in_array($prefix, [
                    'hi', 'ln', 'mg', 'ak', 'tl', 'am', 'bh', 'wa', 'ti', 'guw', 'fil', 'nso'], true)) {
            return new Zero;
        } elseif (in_array($prefix, [
                    'my', 'sg', 'ms', 'lo', 'kn', 'ko', 'th', 'to', 'yo', 'zh', 'wo', 'vi', 'tr', 'az', 'km', 'id',
                    'ig', 'fa', 'dz', 'bm', 'bo', 'ii', 'hu', 'ka', 'jv', 'ja', 'kde', 'ses', 'sah', 'kea'], true)) {
            return new None;
        }
        throw new \InvalidArgumentException('Unknown language prefix: ' . $prefix . '.');
    }

}
