<?php

namespace Application\Model;

class TestModel extends \KORD\ORM
{

    protected $belongs_to = [
        'bar' => [
            'model' => '\Application\Model\Bar',
            'foreign_key' => 'bar_id',
        ],
    ];
    
    //protected $table_columns = ['title'];

}
