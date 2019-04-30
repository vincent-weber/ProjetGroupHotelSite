<?php

class PostRequest{

    public function __construct(){
        var_dump($_POST);
    }


    public function input($inputName)
    {
        return $_POST[$inputName];
    }

}