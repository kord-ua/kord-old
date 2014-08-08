<?php

namespace KORD\Validation;

use KORD\Core;
use KORD\Helper\UTF8;
use KORD\Validation\Hostname;

/**
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 */
class HostnameSrc extends RuleAbstract
{
    const ALLOW_DNS   = 1;  // Allows Internet domain names (e.g., example.com)
    const ALLOW_IP    = 2;  // Allows IP addresses
    const ALLOW_LOCAL = 4;  // Allows local network names (e.g., localhost, www.localdomain)
    const ALLOW_URI   = 8;  // Allows URI hostnames
    const ALLOW_ALL   = 15;  // Allows all types of hostnames

    /**
     * Array of valid top-level-domains
     *
     * @see ftp://data.iana.org/TLD/tlds-alpha-by-domain.txt  List of all TLDs by domain
     * @see http://www.iana.org/domains/root/db/ Official list of supported TLDs
     * @var array
     */
    protected $valid_tlds = [
        'ac', 'academy', 'actor', 'ad', 'ae', 'aero', 'af', 'ag', 'agency', 'ai', 'al', 'am', 'an', 'ao', 'aq', 'ar',
        'arpa', 'as', 'asia', 'at', 'au', 'aw', 'ax', 'az', 'ba', 'bar', 'bargains', 'bb', 'bd', 'be', 'berlin', 'best',
        'bf', 'bg', 'bh', 'bi', 'bike', 'biz', 'bj', 'bl', 'blue', 'bm', 'bn', 'bo', 'boutique', 'bq', 'br', 'bs', 'bt',
        'build', 'builders', 'buzz', 'bv', 'bw', 'by', 'bz', 'ca', 'cab', 'camera', 'camp', 'cards', 'careers', 'cat',
        'catering', 'cc', 'cd', 'center', 'ceo', 'cf', 'cg', 'ch', 'cheap', 'christmas', 'ci', 'ck', 'cl', 'cleaning',
        'clothing', 'club', 'cm', 'cn', 'co', 'codes', 'coffee', 'com', 'community', 'company', 'computer',
        'construction', 'contractors', 'cool', 'coop', 'cr', 'cruises', 'cu', 'cv', 'cw', 'cx', 'cy', 'cz', 'dance',
        'dating', 'de', 'democrat', 'diamonds', 'directory', 'dj', 'dk', 'dm', 'do', 'domains', 'dz', 'ec', 'edu',
        'education', 'ee', 'eg', 'eh', 'email', 'enterprises', 'equipment', 'er', 'es', 'estate', 'et', 'eu', 'events',
        'expert', 'exposed', 'farm', 'fi', 'fish', 'fj', 'fk', 'flights', 'florist', 'fm', 'fo', 'foundation', 'fr',
        'futbol', 'ga', 'gallery', 'gb', 'gd', 'ge', 'gf', 'gg', 'gh', 'gi', 'gift', 'gl', 'glass', 'gm', 'gn', 'gov',
        'gp', 'gq', 'gr', 'graphics', 'gs', 'gt', 'gu', 'guitars', 'guru', 'gw', 'gy', 'hk', 'hm', 'hn', 'holdings',
        'holiday', 'house', 'hr', 'ht', 'hu', 'id', 'ie', 'il', 'im', 'immobilien', 'in', 'industries', 'info',
        'institute', 'int', 'international', 'io', 'iq', 'ir', 'is', 'it', 'je', 'jm', 'jo', 'jobs', 'jp', 'kaufen',
        'ke', 'kg', 'kh', 'ki', 'kim', 'kitchen', 'kiwi', 'km', 'kn', 'kp', 'kr', 'kred', 'kw', 'ky', 'kz', 'la',
        'land', 'lb', 'lc', 'li', 'lighting', 'limo', 'link', 'lk', 'lr', 'ls', 'lt', 'lu', 'luxury', 'lv', 'ly', 'ma',
        'management', 'mango', 'marketing', 'mc', 'md', 'me', 'menu', 'mf', 'mg', 'mh', 'mil', 'mk', 'ml', 'mm', 'mn',
        'mo', 'mobi', 'moda', 'monash', 'mp', 'mq', 'mr', 'ms', 'mt', 'mu', 'museum', 'mv', 'mw', 'mx', 'my', 'mz',
        'na', 'nagoya', 'name', 'nc', 'ne', 'net', 'neustar', 'nf', 'ng', 'ni', 'ninja', 'nl', 'no', 'np', 'nr', 'nu',
        'nz', 'om', 'onl', 'org', 'pa', 'partners', 'parts', 'pe', 'pf', 'pg', 'ph', 'photo', 'photography', 'photos',
        'pics', 'pink', 'pk', 'pl', 'plumbing', 'pm', 'pn', 'post', 'pr', 'pro', 'productions', 'properties', 'ps',
        'pt', 'pub', 'pw', 'py', 'qa', 'qpon', 're', 'recipes', 'red', 'rentals', 'repair', 'report', 'reviews', 'rich',
        'ro', 'rs', 'ru', 'ruhr', 'rw', 'sa', 'sb', 'sc', 'sd', 'se', 'sexy', 'sg', 'sh', 'shiksha', 'shoes', 'si',
        'singles', 'sj', 'sk', 'sl', 'sm', 'sn', 'so', 'social', 'solar', 'solutions', 'sr', 'ss', 'st', 'su',
        'supplies', 'supply', 'support', 'sv', 'sx', 'sy', 'systems', 'sz', 'tattoo', 'tc', 'td', 'technology', 'tel',
        'tf', 'tg', 'th', 'tienda', 'tips', 'tj', 'tk', 'tl', 'tm', 'tn', 'to', 'today', 'tokyo', 'tools', 'tp', 'tr',
        'training', 'travel', 'tt', 'tv', 'tw', 'tz', 'ua', 'ug', 'uk', 'um', 'uno', 'us', 'uy', 'uz', 'va',
        'vacations', 'vc', 've', 'ventures', 'vg', 'vi', 'viajes', 'villas', 'vision', 'vn', 'voting', 'voyage', 'vu',
        'wang', 'watch', 'wed', 'wf', 'wien', 'wiki', 'works', 'ws', '测试', 'परीक्षा', '集团', '在线', '한국', 'ভারত',
        'বাংলা', '公益', '公司', '移动', '我爱你', 'испытание', 'қаз', 'онлайн', 'сайт', 'срб', '테스트', '삼성',
        'சிங்கப்பூர்', 'дети', 'טעסט', '中文网', '中信', '中国', '中國', 'భారత్', 'ලංකා', '測試', 'ભારત', 'भारत',
        'آزمایشی', 'பரிட்சை', '网络', 'укр', '香港', 'δοκιμή', 'إختبار', '台湾', '台灣', 'мон',
        'الجزائر', 'عمان', 'ایران', 'امارات', 'بازار', 'پاکستان', 'الاردن', 'بھارت', 'المغرب', 'السعودية', 'سودان', 'مليسيا', 'شبكة', 'გე',
        'ไทย', 'سورية', 'рф', 'تونس', 'みんな', 'ਭਾਰਤ', '游戏', 'مصر', 'قطر', 'இலங்கை', 'இந்தியா', '新加坡', 'فلسطين',
        'テスト', '政务', 'xxx', 'xyz', 'ye', 'yt', 'za', 'zm', 'zone', 'zw'
    ];

    /**
     * Array for valid Idns
     * @see http://www.iana.org/domains/idn-tables/ Official list of supported IDN Chars
     * (.AC) Ascension Island http://www.nic.ac/pdf/AC-IDN-Policy.pdf
     * (.AR) Argentina http://www.nic.ar/faqidn.html
     * (.AS) American Samoa http://www.nic.as/idn/chars.cfm
     * (.AT) Austria http://www.nic.at/en/service/technical_information/idn/charset_converter/
     * (.BIZ) International http://www.iana.org/domains/idn-tables/
     * (.BR) Brazil http://registro.br/faq/faq6.html
     * (.BV) Bouvett Island http://www.norid.no/domeneregistrering/idn/idn_nyetegn.en.html
     * (.CAT) Catalan http://www.iana.org/domains/idn-tables/tables/cat_ca_1.0.html
     * (.CH) Switzerland https://nic.switch.ch/reg/ocView.action?res=EF6GW2JBPVTG67DLNIQXU234MN6SC33JNQQGI7L6#anhang1
     * (.CL) Chile http://www.iana.org/domains/idn-tables/tables/cl_latn_1.0.html
     * (.COM) International http://www.verisign.com/information-services/naming-services/internationalized-domain-names/index.html
     * (.DE) Germany http://www.denic.de/en/domains/idns/liste.html
     * (.DK) Danmark http://www.dk-hostmaster.dk/index.php?id=151
     * (.ES) Spain https://www.nic.es/media/2008-05/1210147705287.pdf
     * (.FI) Finland http://www.ficora.fi/en/index/palvelut/fiverkkotunnukset/aakkostenkaytto.html
     * (.GR) Greece https://grweb.ics.forth.gr/CharacterTable1_en.jsp
     * (.HU) Hungary http://www.domain.hu/domain/English/szabalyzat/szabalyzat.html
     * (.IL) Israel http://www.isoc.org.il/domains/il-domain-rules.html
     * (.INFO) International http://www.nic.info/info/idn
     * (.IO) British Indian Ocean Territory http://www.nic.io/IO-IDN-Policy.pdf
     * (.IR) Iran http://www.nic.ir/Allowable_Characters_dot-iran
     * (.IS) Iceland http://www.isnic.is/domain/rules.php
     * (.KR) Korea http://www.iana.org/domains/idn-tables/tables/kr_ko-kr_1.0.html
     * (.LI) Liechtenstein https://nic.switch.ch/reg/ocView.action?res=EF6GW2JBPVTG67DLNIQXU234MN6SC33JNQQGI7L6#anhang1
     * (.LT) Lithuania http://www.domreg.lt/static/doc/public/idn_symbols-en.pdf
     * (.MD) Moldova http://www.register.md/
     * (.MUSEUM) International http://www.iana.org/domains/idn-tables/tables/museum_latn_1.0.html
     * (.NET) International http://www.verisign.com/information-services/naming-services/internationalized-domain-names/index.html
     * (.NO) Norway http://www.norid.no/domeneregistrering/idn/idn_nyetegn.en.html
     * (.NU) Niue http://www.worldnames.net/
     * (.ORG) International http://www.pir.org/index.php?db=content/FAQs&tbl=FAQs_Registrant&id=2
     * (.PE) Peru https://www.nic.pe/nuevas_politicas_faq_2.php
     * (.PL) Poland http://www.dns.pl/IDN/allowed_character_sets.pdf
     * (.PR) Puerto Rico http://www.nic.pr/idn_rules.asp
     * (.PT) Portugal https://online.dns.pt/dns_2008/do?com=DS;8216320233;111;+PAGE(4000058)+K-CAT-CODIGO(C.125)+RCNT(100);
     * (.RU) Russia http://www.iana.org/domains/idn-tables/tables/ru_ru-ru_1.0.html
     * (.SA) Saudi Arabia http://www.iana.org/domains/idn-tables/tables/sa_ar_1.0.html
     * (.SE) Sweden http://www.iis.se/english/IDN_campaignsite.shtml?lang=en
     * (.SH) Saint Helena http://www.nic.sh/SH-IDN-Policy.pdf
     * (.SJ) Svalbard and Jan Mayen http://www.norid.no/domeneregistrering/idn/idn_nyetegn.en.html
     * (.TH) Thailand http://www.iana.org/domains/idn-tables/tables/th_th-th_1.0.html
     * (.TM) Turkmenistan http://www.nic.tm/TM-IDN-Policy.pdf
     * (.TR) Turkey https://www.nic.tr/index.php
     * (.UA) Ukraine http://www.iana.org/domains/idn-tables/tables/ua_cyrl_1.2.html
     * (.VE) Venice http://www.iana.org/domains/idn-tables/tables/ve_es_1.0.html
     * (.VN) Vietnam http://www.vnnic.vn/english/5-6-300-2-2-04-20071115.htm#1.%20Introduction
     *
     * @var array
     */
    protected $valid_idns = [
        'AC'  => [1 => '/^[\x{002d}0-9a-zà-öø-ÿāăąćĉċčďđēėęěĝġģĥħīįĵķĺļľŀłńņňŋőœŕŗřśŝşšţťŧūŭůűųŵŷźżž]{1,63}$/iu'],
        'AR'  => [1 => '/^[\x{002d}0-9a-zà-ãç-êìíñ-õü]{1,63}$/iu'],
        'AS'  => [1 => '/^[\x{002d}0-9a-zà-öø-ÿāăąćĉċčďđēĕėęěĝğġģĥħĩīĭįıĵķĸĺļľłńņňŋōŏőœŕŗřśŝşšţťŧũūŭůűųŵŷźż]{1,63}$/iu'],
        'AT'  => [1 => '/^[\x{002d}0-9a-zà-öø-ÿœšž]{1,63}$/iu'],
        'BIZ' => 'biz',
        'BR'  => [1 => '/^[\x{002d}0-9a-zà-ãçéíó-õúü]{1,63}$/iu'],
        'BV'  => [1 => '/^[\x{002d}0-9a-zàáä-éêñ-ôöøüčđńŋšŧž]{1,63}$/iu'],
        'CAT' => [1 => '/^[\x{002d}0-9a-z·àç-éíïòóúü]{1,63}$/iu'],
        'CH'  => [1 => '/^[\x{002d}0-9a-zà-öø-ÿœ]{1,63}$/iu'],
        'CL'  => [1 => '/^[\x{002d}0-9a-záéíñóúü]{1,63}$/iu'],
        'CN'  => 'cn',
        'COM' => 'com',
        'DE'  => [1 => '/^[\x{002d}0-9a-zà-öø-ÿăąāćĉčċďđĕěėęēğĝġģĥħĭĩįīıĵķĺľļłńňņŋŏőōœĸŕřŗśŝšşťţŧŭůűũųūŵŷźžż]{1,63}$/iu'],
        'DK'  => [1 => '/^[\x{002d}0-9a-zäéöü]{1,63}$/iu'],
        'ES'  => [1 => '/^[\x{002d}0-9a-zàáçèéíïñòóúü·]{1,63}$/iu'],
        'EU'  => [1 => '/^[\x{002d}0-9a-zà-öø-ÿ]{1,63}$/iu',
            2 => '/^[\x{002d}0-9a-zāăąćĉċčďđēĕėęěĝğġģĥħĩīĭįıĵķĺļľŀłńņňŉŋōŏőœŕŗřśŝšťŧũūŭůűųŵŷźżž]{1,63}$/iu',
            3 => '/^[\x{002d}0-9a-zșț]{1,63}$/iu',
            4 => '/^[\x{002d}0-9a-zΐάέήίΰαβγδεζηθικλμνξοπρςστυφχψωϊϋόύώ]{1,63}$/iu',
            5 => '/^[\x{002d}0-9a-zабвгдежзийклмнопрстуфхцчшщъыьэюя]{1,63}$/iu',
            6 => '/^[\x{002d}0-9a-zἀ-ἇἐ-ἕἠ-ἧἰ-ἷὀ-ὅὐ-ὗὠ-ὧὰ-ὼώᾀ-ᾇᾐ-ᾗᾠ-ᾧᾰ-ᾴᾶᾷῂῃῄῆῇῐ-ῒΐῖῗῠ-ῧῲῳῴῶῷ]{1,63}$/iu'],
        'FI'  => [1 => '/^[\x{002d}0-9a-zäåö]{1,63}$/iu'],
        'GR'  => [1 => '/^[\x{002d}0-9a-zΆΈΉΊΌΎ-ΡΣ-ώἀ-ἕἘ-Ἕἠ-ὅὈ-Ὅὐ-ὗὙὛὝὟ-ώᾀ-ᾴᾶ-ᾼῂῃῄῆ-ῌῐ-ΐῖ-Ίῠ-Ῥῲῳῴῶ-ῼ]{1,63}$/iu'],
        'HK'  => 'cn',
        'HU'  => [1 => '/^[\x{002d}0-9a-záéíóöúüőű]{1,63}$/iu'],
        'IL'  => [1 => '/^[\x{002d}0-9\x{05D0}-\x{05EA}]{1,63}$/iu',
            2 => '/^[\x{002d}0-9a-z]{1,63}$/i'],
        'INFO'=> [1 => '/^[\x{002d}0-9a-zäåæéöøü]{1,63}$/iu',
            2 => '/^[\x{002d}0-9a-záéíóöúüőű]{1,63}$/iu',
            3 => '/^[\x{002d}0-9a-záæéíðóöúýþ]{1,63}$/iu',
            4 => '/^[\x{AC00}-\x{D7A3}]{1,17}$/iu',
            5 => '/^[\x{002d}0-9a-zāčēģīķļņōŗšūž]{1,63}$/iu',
            6 => '/^[\x{002d}0-9a-ząčėęįšūųž]{1,63}$/iu',
            7 => '/^[\x{002d}0-9a-zóąćęłńśźż]{1,63}$/iu',
            8 => '/^[\x{002d}0-9a-záéíñóúü]{1,63}$/iu'],
        'IO'  => [1 => '/^[\x{002d}0-9a-zà-öø-ÿăąāćĉčċďđĕěėęēğĝġģĥħĭĩįīıĵķĺľļłńňņŋŏőōœĸŕřŗśŝšşťţŧŭůűũųūŵŷźžż]{1,63}$/iu'],
        'IS'  => [1 => '/^[\x{002d}0-9a-záéýúíóþæöð]{1,63}$/iu'],
        'IT'  => [1 => '/^[\x{002d}0-9a-zàâäèéêëìîïòôöùûüæœçÿß-]{1,63}$/iu'],
        'JP'  => 'jp',
        'KR'  => [1 => '/^[\x{AC00}-\x{D7A3}]{1,17}$/iu'],
        'LI'  => [1 => '/^[\x{002d}0-9a-zà-öø-ÿœ]{1,63}$/iu'],
        'LT'  => [1 => '/^[\x{002d}0-9ąčęėįšųūž]{1,63}$/iu'],
        'MD'  => [1 => '/^[\x{002d}0-9ăâîşţ]{1,63}$/iu'],
        'MUSEUM' => [1 => '/^[\x{002d}0-9a-zà-öø-ÿāăąćċčďđēėęěğġģħīįıķĺļľłńņňŋōőœŕŗřśşšţťŧūůűųŵŷźżžǎǐǒǔ\x{01E5}\x{01E7}\x{01E9}\x{01EF}ə\x{0292}ẁẃẅỳ]{1,63}$/iu'],
        'NET' => 'com',
        'NO'  => [1 => '/^[\x{002d}0-9a-zàáä-éêñ-ôöøüčđńŋšŧž]{1,63}$/iu'],
        'NU'  => 'com',
        'ORG' => [1 => '/^[\x{002d}0-9a-záéíñóúü]{1,63}$/iu',
            2 => '/^[\x{002d}0-9a-zóąćęłńśźż]{1,63}$/iu',
            3 => '/^[\x{002d}0-9a-záäåæéëíðóöøúüýþ]{1,63}$/iu',
            4 => '/^[\x{002d}0-9a-záéíóöúüőű]{1,63}$/iu',
            5 => '/^[\x{002d}0-9a-ząčėęįšūųž]{1,63}$/iu',
            6 => '/^[\x{AC00}-\x{D7A3}]{1,17}$/iu',
            7 => '/^[\x{002d}0-9a-zāčēģīķļņōŗšūž]{1,63}$/iu'],
        'PE'  => [1 => '/^[\x{002d}0-9a-zñáéíóúü]{1,63}$/iu'],
        'PL'  => [1 => '/^[\x{002d}0-9a-zāčēģīķļņōŗšūž]{1,63}$/iu',
            2 => '/^[\x{002d}а-ик-ш\x{0450}ѓѕјљњќџ]{1,63}$/iu',
            3 => '/^[\x{002d}0-9a-zâîăşţ]{1,63}$/iu',
            4 => '/^[\x{002d}0-9а-яё\x{04C2}]{1,63}$/iu',
            5 => '/^[\x{002d}0-9a-zàáâèéêìíîòóôùúûċġħż]{1,63}$/iu',
            6 => '/^[\x{002d}0-9a-zàäåæéêòóôöøü]{1,63}$/iu',
            7 => '/^[\x{002d}0-9a-zóąćęłńśźż]{1,63}$/iu',
            8 => '/^[\x{002d}0-9a-zàáâãçéêíòóôõúü]{1,63}$/iu',
            9 => '/^[\x{002d}0-9a-zâîăşţ]{1,63}$/iu',
            10=> '/^[\x{002d}0-9a-záäéíóôúýčďĺľňŕšťž]{1,63}$/iu',
            11=> '/^[\x{002d}0-9a-zçë]{1,63}$/iu',
            12=> '/^[\x{002d}0-9а-ик-шђјљњћџ]{1,63}$/iu',
            13=> '/^[\x{002d}0-9a-zćčđšž]{1,63}$/iu',
            14=> '/^[\x{002d}0-9a-zâçöûüğış]{1,63}$/iu',
            15=> '/^[\x{002d}0-9a-záéíñóúü]{1,63}$/iu',
            16=> '/^[\x{002d}0-9a-zäõöüšž]{1,63}$/iu',
            17=> '/^[\x{002d}0-9a-zĉĝĥĵŝŭ]{1,63}$/iu',
            18=> '/^[\x{002d}0-9a-zâäéëîô]{1,63}$/iu',
            19=> '/^[\x{002d}0-9a-zàáâäåæçèéêëìíîïðñòôöøùúûüýćčłńřśš]{1,63}$/iu',
            20=> '/^[\x{002d}0-9a-zäåæõöøüšž]{1,63}$/iu',
            21=> '/^[\x{002d}0-9a-zàáçèéìíòóùú]{1,63}$/iu',
            22=> '/^[\x{002d}0-9a-zàáéíóöúüőű]{1,63}$/iu',
            23=> '/^[\x{002d}0-9ΐά-ώ]{1,63}$/iu',
            24=> '/^[\x{002d}0-9a-zàáâåæçèéêëðóôöøüþœ]{1,63}$/iu',
            25=> '/^[\x{002d}0-9a-záäéíóöúüýčďěňřšťůž]{1,63}$/iu',
            26=> '/^[\x{002d}0-9a-z·àçèéíïòóúü]{1,63}$/iu',
            27=> '/^[\x{002d}0-9а-ъьюя\x{0450}\x{045D}]{1,63}$/iu',
            28=> '/^[\x{002d}0-9а-яёіў]{1,63}$/iu',
            29=> '/^[\x{002d}0-9a-ząčėęįšūųž]{1,63}$/iu',
            30=> '/^[\x{002d}0-9a-záäåæéëíðóöøúüýþ]{1,63}$/iu',
            31=> '/^[\x{002d}0-9a-zàâæçèéêëîïñôùûüÿœ]{1,63}$/iu',
            32=> '/^[\x{002d}0-9а-щъыьэюяёєіїґ]{1,63}$/iu',
            33=> '/^[\x{002d}0-9א-ת]{1,63}$/iu'],
        'PR'  => [1 => '/^[\x{002d}0-9a-záéíóúñäëïüöâêîôûàèùæçœãõ]{1,63}$/iu'],
        'PT'  => [1 => '/^[\x{002d}0-9a-záàâãçéêíóôõú]{1,63}$/iu'],
        'RU'  => [1 => '/^[\x{002d}0-9а-яё]{1,63}$/iu'],
        'SA'  => [1 => '/^[\x{002d}.0-9\x{0621}-\x{063A}\x{0641}-\x{064A}\x{0660}-\x{0669}]{1,63}$/iu'],
        'SE'  => [1 => '/^[\x{002d}0-9a-zäåéöü]{1,63}$/iu'],
        'SH'  => [1 => '/^[\x{002d}0-9a-zà-öø-ÿăąāćĉčċďđĕěėęēğĝġģĥħĭĩįīıĵķĺľļłńňņŋŏőōœĸŕřŗśŝšşťţŧŭůűũųūŵŷźžż]{1,63}$/iu'],
        'SI'  => [
            1 => '/^[\x{002d}0-9a-zà-öø-ÿ]{1,63}$/iu',
            2 => '/^[\x{002d}0-9a-zāăąćĉċčďđēĕėęěĝğġģĥħĩīĭįıĵķĺļľŀłńņňŉŋōŏőœŕŗřśŝšťŧũūŭůűųŵŷźżž]{1,63}$/iu',
            3 => '/^[\x{002d}0-9a-zșț]{1,63}$/iu'],
        'SJ'  => [1 => '/^[\x{002d}0-9a-zàáä-éêñ-ôöøüčđńŋšŧž]{1,63}$/iu'],
        'TH'  => [1 => '/^[\x{002d}0-9a-z\x{0E01}-\x{0E3A}\x{0E40}-\x{0E4D}\x{0E50}-\x{0E59}]{1,63}$/iu'],
        'TM'  => [1 => '/^[\x{002d}0-9a-zà-öø-ÿāăąćĉċčďđēėęěĝġģĥħīįĵķĺļľŀłńņňŋőœŕŗřśŝşšţťŧūŭůűųŵŷźżž]{1,63}$/iu'],
        'TW'  => 'cn',
        'TR'  => [1 => '/^[\x{002d}0-9a-zğıüşöç]{1,63}$/iu'],
        'UA'  => [1 => '/^[\x{002d}0-9a-zабвгдежзийклмнопрстуфхцчшщъыьэюяѐёђѓєѕіїјљњћќѝўџґӂʼ]{1,63}$/iu'],
        'VE'  => [1 => '/^[\x{002d}0-9a-záéíóúüñ]{1,63}$/iu'],
        'VN'  => [1 => '/^[ÀÁÂÃÈÉÊÌÍÒÓÔÕÙÚÝàáâãèéêìíòóôõùúýĂăĐđĨĩŨũƠơƯư\x{1EA0}-\x{1EF9}]{1,63}$/iu'],
        'мон' => [1 => '/^[\x{002d}0-9\x{0430}-\x{044F}]{1,63}$/iu'],
        'срб' => [1 => '/^[\x{002d}0-9а-ик-шђјљњћџ]{1,63}$/iu'],
        'сайт' => [1 => '/^[\x{002d}0-9а-яёіїѝйўґг]{1,63}$/iu'],
        'онлайн' => [1 => '/^[\x{002d}0-9а-яёіїѝйўґг]{1,63}$/iu'],
        '中国' => 'cn',
        '中國' => 'cn',
        'ලංකා' => [1 => '/^[\x{0d80}-\x{0dff}]{1,63}$/iu'],
        '香港' => 'cn',
        '台湾' => 'cn',
        '台灣' => 'cn',
        'امارات'   => [1 => '/^[\x{0621}-\x{0624}\x{0626}-\x{063A}\x{0641}\x{0642}\x{0644}-\x{0648}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06CC}\x{06F0}-\x{06F9}]{1,30}$/iu'],
        'الاردن'    => [1 => '/^[\x{0621}-\x{0624}\x{0626}-\x{063A}\x{0641}\x{0642}\x{0644}-\x{0648}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06CC}\x{06F0}-\x{06F9}]{1,30}$/iu'],
        'السعودية' => [1 => '/^[\x{0621}-\x{0624}\x{0626}-\x{063A}\x{0641}\x{0642}\x{0644}-\x{0648}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06CC}\x{06F0}-\x{06F9}]{1,30}$/iu'],
        'ไทย' => [1 => '/^[\x{002d}0-9a-z\x{0E01}-\x{0E3A}\x{0E40}-\x{0E4D}\x{0E50}-\x{0E59}]{1,63}$/iu'],
        'рф' => [1 => '/^[\x{002d}0-9а-яё]{1,63}$/iu'],
        'تونس' => [1 => '/^[\x{0621}-\x{0624}\x{0626}-\x{063A}\x{0641}\x{0642}\x{0644}-\x{0648}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06CC}\x{06F0}-\x{06F9}]{1,30}$/iu'],
        'مصر' => [1 => '/^[\x{0621}-\x{0624}\x{0626}-\x{063A}\x{0641}\x{0642}\x{0644}-\x{0648}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06CC}\x{06F0}-\x{06F9}]{1,30}$/iu'],
        'இலங்கை' => [1 => '/^[\x{0b80}-\x{0bff}]{1,63}$/iu'],
        'فلسطين' => [1 => '/^[\x{0621}-\x{0624}\x{0626}-\x{063A}\x{0641}\x{0642}\x{0644}-\x{0648}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06CC}\x{06F0}-\x{06F9}]{1,30}$/iu'],
        'شبكة'  => [1 => '/^[\x{0621}-\x{0624}\x{0626}-\x{063A}\x{0641}\x{0642}\x{0644}-\x{0648}\x{067E}\x{0686}\x{0698}\x{06A9}\x{06AF}\x{06CC}\x{06F0}-\x{06F9}]{1,30}$/iu'],
    ];

    protected $idn_length = [
        'BIZ' => [5 => 17, 11 => 15, 12 => 20],
        'CN'  => [1 => 20],
        'COM' => [3 => 17, 5 => 20],
        'HK'  => [1 => 15],
        'INFO'=> [4 => 17],
        'KR'  => [1 => 17],
        'NET' => [3 => 17, 5 => 20],
        'ORG' => [6 => 17],
        'TW'  => [1 => 20],
        'امارات' => [1 => 30],
        'الاردن' => [1 => 30],
        'السعودية' => [1 => 30],
        'تونس' => [1 => 30],
        'مصر' => [1 => 30],
        'فلسطين' => [1 => 30],
        'شبكة' => [1 => 30],
        '中国' => [1 => 20],
        '中國' => [1 => 20],
        '香港' => [1 => 20],
        '台湾' => [1 => 20],
        '台灣' => [1 => 20],
    ];

    protected $tld;

    /**
     * Options for the hostname validator
     *
     * @var array
     */
    protected $options = [
        'allow'       => Hostname::ALLOW_DNS, // Allow these hostnames
        'idn_check' => true,  // Check IDN domains
        'tld_check' => true,  // Check TLD elements
        'ip_validator' => null,  // IP validator to use
    ];
    
    /**
     * Returns the allow option
     *
     * @return int
     */
    public function getAllow()
    {
        return $this->options['allow'];
    }

    /**
     * Sets the allow option
     *
     * @param  int|array $allow
     * @return $this Provides a fluent interface
     */
    public function setAllow($allow)
    {
        if (is_array($allow)) {
            $allow = array_sum($allow);
        }
        $this->options['allow'] = $allow;
        return $this;
    }

    /**
     * Returns the set idn_check option
     *
     * @return bool
     */
    public function getIdnCheck()
    {
        return $this->options['idn_check'];
    }

    /**
     * Set whether IDN domains are validated
     *
     * This only applies when DNS hostnames are validated
     *
     * @param  bool $flag Set to true to validate IDN domains
     * @return $this
     */
    public function useIdnCheck($flag)
    {
        $this->options['idn_check'] = (bool) $flag;
        return $this;
    }

    /**
     * Returns the set tld_check option
     *
     * @return bool
     */
    public function getTldCheck()
    {
        return $this->options['tld_check'];
    }

    /**
     * Set whether the TLD element of a hostname is validated
     *
     * This only applies when DNS hostnames are validated
     *
     * @param  bool $flag Set to true to validate TLD elements
     * @return $this
     */
    public function useTldCheck($flag)
    {
        $this->options['tld_check'] = (bool) $flag;
        return $this;
    }
    
    /**
     * Returns the set ip validator
     *
     * @return IP
     */
    public function getIpValidator()
    {
        if (!isset($this->options['ip_validator'])) {
           $this->options['ip_validator'] = new IP();
        }
        
        return $this->options['ip_validator'];
    }

    /**
     * Sets IP Validator to use
     *
     * @param IP $ip_validator
     * @return $this;
     */
    public function setIpValidator(IP $ip_validator)
    {
        $this->options['ip_validator'] = $ip_validator;
        return $this;
    }

    /**
     * Defined by \KORD\Validation\RuleInterface
     *
     * Returns true if and only if the $value is a valid hostname with respect to the current allow option
     *
     * @param  string $value
     * @return bool
     */
    public function isValid($value)
    {
        if (!is_string($value)) {
            $this->addError('hostnameInvalid');
            return false;
        }
        
        // Check input against IP address schema
        if (preg_match('/^[0-9a-f:.]*$/i', $value) 
            AND $this->getIpValidator()->isValid($value)) {
            if (!($this->getAllow() & Hostname::ALLOW_IP)) {
                $this->addError('hostnameIpAddressNotAllowed');
                return false;
            } else {
                return true;
            }
        }

        // Local hostnames are allowed to be partial (ending '.')
        if ($this->getAllow() & Hostname::ALLOW_LOCAL) {
            if (substr($value, -1) === '.') {
                $value = substr($value, 0, -1);
                if (substr($value, -1) === '.') {
                    // Empty hostnames (ending '..') are not allowed
                    $this->addError('hostnameInvalidLocalName');
                    return false;
                }
            }
        }

        $domain_parts = explode('.', $value);

        // Prevent partial IP V4 addresses (ending '.')
        if ((count($domain_parts) == 4) AND preg_match('/^[0-9.a-e:.]*$/i', $value) 
             AND $this->getIpValidator()->isValid($value)) {
            $this->error('hostnameInvalidLocalName');
        }

        // Check input against DNS hostname schema
        if ((count($domain_parts) > 1)
            AND (UTF8::strlen($value) >= 4)
            AND (UTF8::strlen($value) <= 254))
        {
            $status = false;

            do {
                // First check TLD
                $matches = [];
                if (preg_match('/([^.]{2,10})$/iu', end($domain_parts), $matches)
                    OR (array_key_exists(end($domain_parts), $this->valid_idns))) {
                    reset($domain_parts);

                    // Hostname characters are: *(label dot)(label dot label); max 254 chars
                    // label: id-prefix [*ldh{61} id-prefix]; max 63 chars
                    // id-prefix: alpha / digit
                    // ldh: alpha / digit / dash

                    // Match TLD against known list
                    $this->tld = strtoupper($matches[1]);
                    if ($this->getTldCheck()) {
                        if (!in_array(strtolower($this->tld), $this->valid_tlds)
                            AND !in_array($this->tld, $this->valid_tlds)) {
                            $this->addError('hostnameUnknownTld');
                            $status = false;
                            break;
                        }
                        // We have already validated that the TLD is fine. We don't want it to go through the below
                        // checks as new UTF-8 TLDs will incorrectly fail if there is no IDN regex for it.
                        array_pop($domain_parts);
                    }

                    /**
                     * Match against IDN hostnames
                     * Note: Keep label regex short to avoid issues with long patterns when matching IDN hostnames
                     */
                    $regex_chars = [0 => '/^[a-z0-9\x2d]{1,63}$/i'];
                    if ($this->getIdnCheck() AND isset($this->valid_idns[$this->tld])) {
                        if (is_string($this->valid_idns[$this->tld])) {
                            $regex_chars += include Core::findFile('hostname', $this->valid_idns[$this->tld]);
                        } else {
                            $regex_chars += $this->valid_idns[$this->tld];
                        }
                    }

                    // Check each hostname part
                    $check = 0;
                    foreach ($domain_parts as $domain_part) {
                        // Decode Punycode domain names to IDN
                        if (strpos($domain_part, 'xn--') === 0) {
                            $domain_part = $this->decodePunycode(substr($domain_part, 4));
                            if ($domain_part === false) {
                                return false;
                            }
                        }

                        // Check dash (-) does not start, end or appear in 3rd and 4th positions
                        if ((UTF8::strpos($domain_part, '-') === 0)
                            OR ((UTF8::strlen($domain_part) > 2) AND (UTF8::strpos($domain_part, '-', 2) == 2) AND (UTF8::strpos($domain_part, '-', 3) == 3))
                            OR (UTF8::strpos($domain_part, '-') === (UTF8::strlen($domain_part) - 1))) {
                            $this->addError('hostnameDashCharacter');
                            $status = false;
                            break 2;
                        }

                        // Check each domain part
                        $checked = false;
                        foreach ($regex_chars as $regex_key => $regex_char) {
                            $status = @preg_match($regex_char, $domain_part);
                            if ($status > 0) {
                                $length = 63;
                                if (array_key_exists($this->tld, $this->idn_length)
                                    AND (array_key_exists($regex_key, $this->idn_length[$this->tld]))) {
                                    $length = $this->idn_length[$this->tld];
                                }

                                if (UTF8::strlen($domain_part) > $length) {
                                    $this->addError('hostnameInvalidHostname');
                                    $status = false;
                                } else {
                                    $checked = true;
                                    break;
                                }
                            }
                        }

                        if ($checked) {
                            ++$check;
                        }
                    }

                    // If one of the labels doesn't match, the hostname is invalid
                    if ($check !== count($domain_parts)) {
                        $this->addError('hostnameInvalidHostnameSchema', ['tld' => $this->tld]);
                        $status = false;
                    }
                } else {
                    // Hostname not long enough
                    $this->addError('hostnameUndecipherableTld');
                    $status = false;
                }
            } while (false);

            // If the input passes as an Internet domain name, and domain names are allowed, then the hostname
            // passes validation
            if ($status AND ($this->getAllow() & Hostname::ALLOW_DNS)) {
                return true;
            }
        } elseif ($this->getAllow() & Hostname::ALLOW_DNS) {
            $this->addError('hostnameInvalidHostname');
            $status = false;
        }

        // Check for URI Syntax (RFC3986)
        if ($this->getAllow() & Hostname::ALLOW_URI) {
            if (preg_match("/^([a-zA-Z0-9-._~!$&\'()*+,;=]|%[[:xdigit:]]{2}){1,254}$/i", $value)) {
                return true;
            } else {
                $this->addError('hostnameInvalidUri');
            }
        }

        // Check input against local network name schema; last chance to pass validation
        $regex_local = '/^(([a-zA-Z0-9\x2d]{1,63}\x2e)*[a-zA-Z0-9\x2d]{1,63}[\x2e]{0,1}){1,254}$/';
        $status = @preg_match($regex_local, $value);

        // If the input passes as a local network name, and local network names are allowed, then the
        // hostname passes validation
        $allow_local = $this->getAllow() & Hostname::ALLOW_LOCAL;
        if ($status AND $allow_local) {
            return true;
        }

        // If the input does not pass as a local network name, add a message
        if (!$status) {
            $this->addError('hostnameInvalidLocalName');
        }

        // If local network names are not allowed, add a message
        if ($status AND !$allow_local) {
            $this->addError('hostnameLocalNameNotAllowed');
        }

        return false;
    }

    /**
     * Decodes a punycode encoded string to it's original utf8 string
     * Returns false in case of a decoding failure.
     *
     * @param  string $encoded Punycode encoded string to decode
     * @return string|false
     */
    protected function decodePunycode($encoded)
    {
        if (!preg_match('/^[a-z0-9-]+$/i', $encoded)) {
            // no punycode encoded string
            $this->addError('hostnameCannotDecodePunycode');
            return false;
        }

        $decoded = [];
        $separator = strrpos($encoded, '-');
        if ($separator > 0) {
            for ($x = 0; $x < $separator; ++$x) {
                // prepare decoding matrix
                $decoded[] = ord($encoded[$x]);
            }
        }

        $lengthd = count($decoded);
        $lengthe = strlen($encoded);

        // decoding
        $init  = true;
        $base  = 72;
        $index = 0;
        $char  = 0x80;

        for ($indexe = ($separator) ? ($separator + 1) : 0; $indexe < $lengthe; ++$lengthd) {
            for ($oldIndex = $index, $pos = 1, $key = 36; 1; $key += 36) {
                $hex   = ord($encoded[$indexe++]);
                $digit = ($hex - 48 < 10) ? $hex - 22
                       : (($hex - 65 < 26) ? $hex - 65
                       : (($hex - 97 < 26) ? $hex - 97
                       : 36));

                $index += $digit * $pos;
                $tag    = ($key <= $base) ? 1 : (($key >= $base + 26) ? 26 : ($key - $base));
                if ($digit < $tag) {
                    break;
                }

                $pos = (int) ($pos * (36 - $tag));
            }

            $delta   = intval($init ? (($index - $oldIndex) / 700) : (($index - $oldIndex) / 2));
            $delta  += intval($delta / ($lengthd + 1));
            for ($key = 0; $delta > 910 / 2; $key += 36) {
                $delta = intval($delta / 35);
            }

            $base   = intval($key + 36 * $delta / ($delta + 38));
            $init   = false;
            $char  += (int) ($index / ($lengthd + 1));
            $index %= ($lengthd + 1);
            if ($lengthd > 0) {
                for ($i = $lengthd; $i > $index; $i--) {
                    $decoded[$i] = $decoded[($i - 1)];
                }
            }

            $decoded[$index++] = $char;
        }

        // convert decoded ucs4 to utf8 string
        foreach ($decoded as $key => $value) {
            if ($value < 128) {
                $decoded[$key] = chr($value);
            } elseif ($value < (1 << 11)) {
                $decoded[$key]  = chr(192 + ($value >> 6));
                $decoded[$key] .= chr(128 + ($value & 63));
            } elseif ($value < (1 << 16)) {
                $decoded[$key]  = chr(224 + ($value >> 12));
                $decoded[$key] .= chr(128 + (($value >> 6) & 63));
                $decoded[$key] .= chr(128 + ($value & 63));
            } elseif ($value < (1 << 21)) {
                $decoded[$key]  = chr(240 + ($value >> 18));
                $decoded[$key] .= chr(128 + (($value >> 12) & 63));
                $decoded[$key] .= chr(128 + (($value >> 6) & 63));
                $decoded[$key] .= chr(128 + ($value & 63));
            } else {
                $this->addError('hostnameCannotDecodePunycode');
                return false;
            }
        }

        return implode($decoded);
    }
}
