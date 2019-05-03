<?php

class PostRequest{

    public function input($inputName)
    {
        return $_POST[$inputName];
    }


    public function getNbPostElements(){
        return count($_POST);
    }

}