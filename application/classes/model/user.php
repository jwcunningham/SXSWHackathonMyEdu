<?php
class Model_User extends ORM {
    protected $_table_name = 'users';

    protected $_has_many = array(
        'roles' => array(
            'model' => 'role', 'through' => 'roles_users',
            'foreign_key' => 'user_id', 'far_key' => 'role_id'
        )
    );
}
