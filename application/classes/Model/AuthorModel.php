<?php

namespace Application\Model;

class AuthorModel extends \KORD\ORM
{
    protected $has_many = array(
      'articles'    => array(
                   'model'         => 'article',
                   'foreign_key' => 'author_id',
               )
    );
}
