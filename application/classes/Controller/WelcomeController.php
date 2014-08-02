<?php

namespace Application\Controller;

class WelcomeController extends \KORD\Controller
{

    public function indexAction()
    {
        $this->response->body('Hello World!');
    }

}
