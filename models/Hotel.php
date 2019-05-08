<?php


class Hotel extends Model{

    protected $table = "Hotel";
    protected $primaryKey = "num_h";

    public static function sort($a, $b) 
	{
		return strcmp($a->ville_h, $b->ville_h);
	}
    
}