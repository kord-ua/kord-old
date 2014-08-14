<?php

namespace KORD\Form;

use KORD\Security\CSRF as SecurityCSRF;

/**
 * @copyright  (c) 2014 Andriy Strepetov
 */
class CSRFSrc extends Element
{
    
    protected $view = 'csrf';
    
    public function __construct($name)
    {
        parent::__construct($name);
        $this->addRule(new \KORD\Validation\CSRF());
    }
    
    public function getNewToken()
    {
        return SecurityCSRF::newToken();
    }

}
