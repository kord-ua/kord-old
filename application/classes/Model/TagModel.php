<?php

namespace Application\Model;

class TagModel extends \KORD\ORM
{
    protected $has_many = array(
       'articles'       => [
           'through' => 'articles_tags'
       ]
          );
}
