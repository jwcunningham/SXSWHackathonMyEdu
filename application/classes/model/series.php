<?php
class Model_Series extends ORM {
    protected $_table_name = 'series';

    protected $_has_many = array(
        'images' => array(
            'model' => 'image',
            'foreign_key' => 'series_key', 
            'far_key' => 'image_key'
        )
    );

}
