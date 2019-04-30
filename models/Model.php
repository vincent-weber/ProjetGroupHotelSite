<?php

class Model {

    public function insert($query,$debug = false){
        return DB::insert($query,$debug);
    }

    public function getWhereId($id){
        $object = DB::selectOne("select * from ".get_called_class()." where $this->primaryKey = $id");
        $obj = strtolower(get_called_class());
        $this->$obj = $object;
        return $this->$obj;
    }

    public static function findOne($id){
        $class = get_called_class();
        $object = DB::selectOne("select * from ".$class." where  id = ".$id);
        return (new $class($object))->display();
    }

    public static function findAll(){
        echo "FIND ALL";

        $class = get_called_class();
        $allObjects = array();

        $objects = DB::prepare("select * from ".get_called_class());
        foreach($objects as $object){
            $obj = (new $class($object))->display();
            array_push($allObjects, $obj);
        }
        return $allObjects;

    }

    public static function findAllWhere($whereCondition)
    {
        $class = get_called_class();
        $allObjects = array();

        $objects = DB::prepare("select * from ".$class." where ".$whereCondition);
        foreach($objects as $object){
            $obj = (new $class($object))->display();
            array_push($allObjects, $obj);
        }
        return $allObjects;
    }

    public static function findOneWhere($whereCondition)
    {
        $class = get_called_class();
        $object = DB::selectOne("select * from ".$class." where ".$whereCondition);
        if($object === false){
            return $object;
        }
        return (new $class($object));
    }


    public function bind($object){
        if($object !== null){
            $objectAttibutes = get_object_vars($object);
            foreach($objectAttibutes as $attibut => $value){
               $this->$attibut = $value;
            }
            $this->setType();
        }
    }


    public function save(){
        $this->setType();
        $columnAndValues = [];

        $query = "insert into ".$this->table." (";

        $columns = DB::prepare("DESCRIBE ".$this->table);
        foreach($columns as $column){

            $field = $column->Field;
            if(isset($this->$field)){
                array_push($columnAndValues, [$field => $this->$field]);
            }
        }
        $firstField = key($columnAndValues[0]);
        $firstValue = $columnAndValues[0][key($columnAndValues[0])];
        unset($columnAndValues[0]);
        $query .= $firstField;
        foreach($columnAndValues as $columnAndValue){
            foreach($columnAndValue as $key => $value){
                $query .= ",".$key;
            }  
        }
        if (gettype($firstValue) === "string"){
            $firstValue = "'".$firstValue."'";
        } 
        $query .= ") values(".$firstValue;

        foreach($columnAndValues as $columnAndValue){
            foreach($columnAndValue as $key => $value){
                if (gettype($value) === "string"){
                    $value = "'".$value."'";
                } 
                $query .= ",".$value;
            }  
        }
        $query .= ")";
        $primaryKey = $this->primaryKey;
        $id = DB::insert($query);
        $this->$primaryKey = $id;
        return $id;
    }

    public static function query($query){
        $res = DB::query($query);
        $res = $res->fetchObject(get_called_class());
        return $res;
    }

    public function setType(){
        if(isset($this->id))
            $this->id = intval($this->id);
    }


    public function display(){
        unset($this->table);
        unset($this->primaryKey);
        return $this;
    }
}