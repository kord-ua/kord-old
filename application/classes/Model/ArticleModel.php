<?php

namespace Application\Model;

class ArticleModel extends \KORD\ORM
{
    protected $belongs_to = [
        'author'    => []
    ];
    
    protected $has_many = array(
       'tags'       => []
          );
}
