<?php

class UsersController extends AppController{

    public function login(){
        if($this->Auth($this->data)){
            echo "ha";
        }else{
            echo "he";
        }
    }

}

?>