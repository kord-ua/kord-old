<?php

namespace KORD\Helper\Text;

/**
 * @copyright  (c) 2007–2014 Kohana Team
 * @copyright  (c) 2014 Andriy Strepetov
 */
class UserAgentSrc
{
    public static $platform = [
        'windows nt 6.2' => 'Windows 8',
        'windows nt 6.1' => 'Windows 7',
        'windows nt 6.0' => 'Windows Vista',
        'windows nt 5.2' => 'Windows 2003',
        'windows nt 5.1' => 'Windows XP',
        'windows nt 5.0' => 'Windows 2000',
        'windows nt 4.0' => 'Windows NT',
        'winnt4.0'       => 'Windows NT',
        'winnt 4.0'      => 'Windows NT',
        'winnt'          => 'Windows NT',
        'windows 98'     => 'Windows 98',
        'win98'          => 'Windows 98',
        'windows 95'     => 'Windows 95',
        'win95'          => 'Windows 95',
        'windows'        => 'Unknown Windows OS',
        'os x'           => 'Mac OS X',
        'intel mac'      => 'Intel Mac',
        'ppc mac'        => 'PowerPC Mac',
        'powerpc'        => 'PowerPC',
        'ppc'            => 'PowerPC',
        'cygwin'         => 'Cygwin',
        'linux'          => 'Linux',
        'debian'         => 'Debian',
        'openvms'        => 'OpenVMS',
        'sunos'          => 'Sun Solaris',
        'amiga'          => 'Amiga',
        'beos'           => 'BeOS',
        'apachebench'    => 'ApacheBench',
        'freebsd'        => 'FreeBSD',
        'netbsd'         => 'NetBSD',
        'bsdi'           => 'BSDi',
        'openbsd'        => 'OpenBSD',
        'os/2'           => 'OS/2',
        'warp'           => 'OS/2',
        'aix'            => 'AIX',
        'irix'           => 'Irix',
        'osf'            => 'DEC OSF',
        'hp-ux'          => 'HP-UX',
        'hurd'           => 'GNU/Hurd',
        'unix'           => 'Unknown Unix OS',
    ];
    
    public static $browser = [
        'Opera'             => 'Opera',
        'MSIE'              => 'Internet Explorer',
        'Internet Explorer' => 'Internet Explorer',
        'Shiira'            => 'Shiira',
        'Firefox'           => 'Firefox',
        'Chimera'           => 'Chimera',
        'Phoenix'           => 'Phoenix',
        'Firebird'          => 'Firebird',
        'Camino'            => 'Camino',
        'Navigator'         => 'Netscape',
        'Netscape'          => 'Netscape',
        'OmniWeb'           => 'OmniWeb',
        'Chrome'            => 'Chrome',
        'Safari'            => 'Safari',
        'CFNetwork'         => 'Safari', // Core Foundation for OSX, WebKit/Safari
        'Konqueror'         => 'Konqueror',
        'Epiphany'          => 'Epiphany',
        'Galeon'            => 'Galeon',
        'Mozilla'           => 'Mozilla',
        'icab'              => 'iCab',
        'lynx'              => 'Lynx',
        'links'             => 'Links',
        'hotjava'           => 'HotJava',
        'amaya'             => 'Amaya',
        'IBrowse'           => 'IBrowse',
    ];
    
    public static $mobile = [
        'mobileexplorer' => 'Mobile Explorer',
        'openwave'       => 'Open Wave',
        'opera mini'     => 'Opera Mini',
        'operamini'      => 'Opera Mini',
        'elaine'         => 'Palm',
        'palmsource'     => 'Palm',
        'digital paths'  => 'Palm',
        'avantgo'        => 'Avantgo',
        'xiino'          => 'Xiino',
        'palmscape'      => 'Palmscape',
        'nokia'          => 'Nokia',
        'ericsson'       => 'Ericsson',
        'blackBerry'     => 'BlackBerry',
        'motorola'       => 'Motorola',
        'iphone'         => 'iPhone',
        'ipad'           => 'iPad',
        'ipod'           => 'iPod',
        'android'        => 'Android',
    ];
    
    public static $robot = [
        'googlebot'           => 'Googlebot',
        'msnbot'              => 'MSNBot',
        'facebookexternalhit' => 'Facebook',
        'slurp'               => 'Inktomi Slurp',
        'yahoo'               => 'Yahoo',
        'askjeeves'           => 'AskJeeves',
        'fastcrawler'         => 'FastCrawler',
        'infoseek'            => 'InfoSeek Robot 1.0',
        'lycos'               => 'Lycos',
    ];
    
}
