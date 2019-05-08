<?php

class TypeChambre extends Model{

    protected $table = "TypeChambre";
    protected $primaryKey = "nom_t";

    public static function sort($a, $b) 
	{
		return  intval($b->prix_t) - intval($a->prix_t);
	}
}


