<?php

namespace KORD;

use KORD\Page;
use KORD\Request;
use KORD\Response;

class Controller extends ControllerSrc
{
    
    /**
     * @var  \KORD\Page The page that will be used for html generation
     */
    public $page;
    
    /**
     * Creates a new controller instance. Each controller must be constructed
     * with the request object that created it.
     *
     * @param   \KORD\Request   $request  Request that created the controller
     * @param   \KORD\Response  $response The request's response
     * @return  void
     */
    public function __construct(Request $request, Response $response)
    {
        parent::__construct($request, $response);
        
        // Assign the request to the controller
        $this->request = $request;

        // Assign a response to the controller
        $this->response = $response;
        
        // Assign a page to the controller
        $this->page = new Page;
    }
    
    /**
     * Automatically executed after the controller action. Can be used to apply
     * transformation to the response, add extra output, and execute
     * other custom code.
     *
     * @return  void
     */
    public function after()
    {
        /*Template::instance()->addCssFile('qq/test.css');
        $this->page->css = Template::instance()->getCss();
        $this->page->js = Template::instance()->getJs();
        
        $title = 'line1';
        
        $sql = \KORD\DB::select()
                ->from('test')
                ->where('title', '=', '?')
                ->bindParam(1, $title);
        
        var_dump($sql->execute()
                ->asArray());
        
        $results = $sql->asObject('\Application\TestClass', ['test' => 'foobar'])->execute();
                var_dump($results);
        
        foreach ($results as $value) {
            echo $value->id;
        }
        
        $this->page->title = 'Test';
        $this->response->body((new Mustache())
                        ->getEngine()
                        ->loadTemplate('layout')
                        ->render($this->page));*/
        parent::after();
    }
    
}
