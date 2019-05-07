<?php

class PostRequest{

    public function input($inputName)
    {
        return $_POST[$inputName];
    }


    public function getNbPostElements(){
        return count($_POST);
    }

    public function getAllElements(){
        return $_POST;
    }

    public function isNullOrEmpty(){
        $count = 0;
        if($this->getNbPostElements() > 0){
            foreach($_POST as $key => $value){
                if(trim($value) === ''){
                    $count++;
                }
            }
        }
        if($count == $this->getNbPostElements()) return true;
        return false;
    }
}