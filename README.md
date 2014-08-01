# KORD PHP Framework

KORD is an elegant, open source, and object oriented HMVC framework built using PHP5. It aims to be swift, secure, and small. KORD framework is initially based on Kohana framework, but contains a lot of new features.

## New features
* Complete PSR-compatibility: PSR-0 and PSR-4 for classes autoload, PSR-1 and PSR-2 for coding style, PSR-3 for logging
* Requires PHP version >=5.4 - uses short array syntax, namespaces, class member access on instantiation, traits (coming soon)
* Advanced core multi-language support
* Many Kohana core classes are completely/partially rewritten (see below), some classes are added from Zend Framework (validation and filtration)

## Core classes changes

### Core (KORD\Core)
* I18n object is now being attached to Core and the following code:
`__('Translate me')`
is now equivalent to
`Core::$i18n->translate('Translate me')`.
Thus, multiple translators can be used within one application.

### Date (KORD\Date)
* `Date::fuzzySpan` and `Date::format()` are now internationalized. Based on [I18n_Plural](https://github.com/czukowski/I18n_Plural)

### Filtration (KORD\Filtration)
* Based on Zend Framework filters
* Multiple filters are supported

### Form (KORD\Form)
* Contains areas (e.g. tabs), each area contains elements (inputs, selects, buttons etc.). 
* Multiple filters and validation rules (plus validation errors) can be assigned to each element
* Each element is bound to a view file (can be custom)
* Each element can be single-lingual or multi-lingual (one input instance per language, each is being validated and filtered separately)

### I18n (KORD\I18n)
* Based on [I18n_Plural](https://github.com/czukowski/I18n_Plural)

### Log (KORD\Log)
* PSR-3 support

### Request (KORD\Request)
* Kohana Request `directory` property is deprecated as namespaces are now being used

### Route (KORD\Route and KORD\RouteRepository)
* Initialized routes are now being stored in a separate class (repository)
