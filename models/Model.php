<?php

/*

Modifier plein de truc, ça a été fait très vite et mal

*/



class Model {

    public function insert($query,$debug = false){
        return DB::insert($query,$debug);
    }
	public function update($set,$where,$debug = false){
		$query = "update ". $this->table." set ".$set." where ". $where;
        return DB::update($query,$debug);
    }
	
	public function delete($where,$debug = false){
		$query = "delete from ". $this->table." where ". $where;
        return DB::delete($query,$debug);
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
        return (new $class())->bind($object);
    }

    public static function findAll(){
        $class = get_called_class();
        $allObjects = array();

        $objects = DB::select("select * from ".get_called_class());
        foreach($objects as $object){
            $obj = (new $class())->bind($object);
            array_push($allObjects, $obj);
        }
        return $allObjects;

    }

    public static function findAllWhere($whereCondition)
    {
        $class = get_called_class();
        $allObjects = array();

        $objects = DB::select("select * from ".$class." where ".$whereCondition);
        foreach($objects as $object){
            $obj = (new $class())->bind($object);
            array_push($allObjects, $obj);
        }
        return $allObjects;
    }

    public static function findOneWhere($whereCondition)
    {
        $class = get_called_class();
        $object = DB::select("select * from ".$class." where ".$whereCondition);

        if(count($object) == 1)
        {
            return (new $class())->bind($object[0]);
        }
        else 
            return null;
        
    }

    public static function select($query){
        $class = get_called_class();
        $allObjects = array();

        $objects = DB::select($query);
        foreach($objects as $object){
            $obj = (new $class())->bind($object);
            array_push($allObjects, $obj);
        }
        return $allObjects;
    }

    
    public function bind($object){
        if($object !== null){
            $objectAttibutes = get_object_vars($object);
            foreach($objectAttibutes as $attibut => $value){
               $this->$attibut = $value;
            }
        }
        return $this;
    }


    public function save(){
        $columnAndValues = [];

        $query = "insert into ".$this->table." (";

        $columns = DB::select("DESCRIBE ".$this->table);
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

    public function display(){
        unset($this->table);
        unset($this->primaryKey);
        return $this;
    }
}