<?php
class Model_Image extends ORM {
    protected $_table_name = 'image';
    protected $_belongs_to = array(
        'series' => array(
            'foreign_key' => 'series_key',
            'far_key' => 'image_key'
        )
    );
}
