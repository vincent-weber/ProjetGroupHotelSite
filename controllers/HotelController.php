<?php
class HotelController{

	public function index($request) {

		if(!$request->isNullOrEmpty()){

			$query = "select num_h,nom_h,ville_h,adresse_h,latitude_h,longitude_h from Hotel where ville_h='".$request->input("ville")."'";// todo
			$hotels = Hotel::select($query);
			
		}
		else{
			$hotels = Hotel::findAll();
		}
		$villes = DB::select("Select distinct(ville_h) from Hotel");
		$typeChambres = TypeChambre::findAll();

		return view("welcomePage",["hotels"=> $hotels, "villes" => $villes, "typeChambres" => $typeChambres]);
	}

}