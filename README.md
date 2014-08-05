**CURRENT VERSION IS FOR EDUCATIONAL PURPOSES ONLY, DO NOT USE IT FOR PRODUCTION**

# KORD PHP Framework

KORD is an elegant, open source, and object oriented HMVC framework built using PHP5. It aims to be swift, secure, and small. KORD framework is initially based on Kohana framework, but contains a lot of new features.

KORD framework is licensed under the BSD License. All original scripts (Kohana Framework, Zend Framework, phputf8 and other) are licensed under their original licenses.

## New features
* Complete PSR-compatibility: PSR-0 and PSR-4 for classes autoloading, PSR-1 and PSR-2 for coding style, PSR-3 for logging
* Requires PHP version >=5.4 - uses short array syntax, namespaces, class member access on instantiation, traits (coming soon)
* Advanced core multi-language support
* Many Kohana core classes are completely/partially rewritten (see below), some classes are based on Zend Framework classes (validation and filtration)

## Core classes changes

### Core (KORD\Core)
* I18n object is now being attached to Core and the following code:
`__('Translate me')`
is now equivalent to
`Core::$i18n->translate('Translate me')`.
Thus, multiple translators can be used within one application.

### Date (KORD\Helper\Date)
* `Date::fuzzySpan()` and `Date::format()` are now internationalized. Based on [I18n_Plural](https://github.com/czukowski/I18n_Plural)

### Exception (KORD\Exception)
* Exception placeholders are now with braces around context keys instead of colons (e.g. `throw new Exception("This {var} is invalid", ['var' => $var])` instead of `throw new Exception("This :var is invalid", [':var' => $var])`) according to section 1.2 of PSR-3

### Filtration (KORD\Filtration)
* Based on Zend Framework filters
* Multiple filters for one value are supported

### Form (KORD\Form)
* Contains areas (e.g. tabs), each area contains elements (inputs, selects, buttons etc.). 
* Multiple filters and validation rules (plus validation errors) can be assigned to each element
* Each element is bound to a view file (can be custom)
* Each element can be single-lingual or multi-lingual (one input instance per language, each is being validated and filtered separately)

### I18n (KORD\I18n)
* Based on [I18n_Plural](https://github.com/czukowski/I18n_Plural)
* Multiple readers are supported

### Log (KORD\Log)
* PSR-3 compatible

### Request (KORD\Request)
* Kohana Request `directory` property is deprecated as namespaces are now being used

### Route (KORD\Route and KORD\Route\Repository)
* Initialized routes are now being stored in a separate class (repository)
* Routes do not contain `directory` param (see KORD\Request)

### Server (KORD\Helper\Server)
* Contains methods to handle $_SERVER array

### UTF8 (KORD\Helper\UTF8)
* `iconv()` and `$charset` are used in `UTF8::strlen`, `UTF8::strtolower` and `UTF8::strtoupper` for better encoding compatibility (used in filtration/validation)
* Three separate functions to check if unicode (`unicodeEnabled()`) and mbstring (`mbstringEnabled()`) are enabled and if encoding is upported by mbstring (`mbstringEncodingSupported(...)`)

### Validation (KORD\Validation)
* Validation rules are based on Zend Framework validators
* Rules are combined into chains, chains can be broken on first validation rule check failure (one error message), or all validation rules will be checked (one error message per failed validation rule)

## Modules

### Database
* MySQL driver is deprecated. PDO and MySQLi drivers are available.
* `list_tables` and `list_columns` methods are deprecated as they are not supported by PDO

### ORM
* Table columns are now being cached
* Validation and filtration inside ORM is removed

## File structure
/ application - folder for application<br />
/ application / cache<br />
/ application / classes - folder for application classes (Application namespace)<br />
/ application / config<br />
/ application / logs<br />
/ application / vendor - folder for customized KORD classes and 3rd party classes<br />
/ application / views<br />
/ modules - folder for modules<br />
/ public - folder for public files (js, css, images etc.)<br />
/ system - system folder<br />
/ system / config<br />
/ system / hostname - hostnames for Hostname validator<br />
/ system / i18n - translations<br />
/ system / vendor - folder with KORD classes and 3rd party classes<br />
/ system / vendor / KORD - folder with KORD classes<br />
/ system / vendor / KORD / application - KORD classes that can be copied into `/application/vendor/KORD` folder and customized<br />
/ system / vendor / KORD / src - source KORD classes<br />
/ system / views
