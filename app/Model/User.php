<?php

class User extends AppModel{

    public $validate = array(
        'name' => array('notEmtpy')
    );

    public function beforeSave($array){
        debug($this->data);die;
    }

}

?>