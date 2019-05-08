<?php
class HotelController{

	public function index($request) {

		$villes = DB::select("Select distinct(ville_h) from Hotel order by ville_h");
		$typeChambres = TypeChambre::findAll();

		if($request->getNbPostElements() > 0){
			$query = "SELECT DISTINCT(ho.num_h),nom_h,ville_h,adresse_h,latitude_h,longitude_h FROM Hotel ho 
			LEFT JOIN Chambre ch ON ch.num_h=ho.num_h
			LEFT JOIN Historique hi ON hi.num_h=ch.num_h AND hi.num_c=ch.num_c";// todo
			if(trim($request->input("ville")) !== ''){
				$query .= " WHERE ho.ville_h = '".$request->input("ville")."'";
			}

			$hotels = Hotel::select($query);
			if(count($hotels)==0){
				$hotels = Hotel::findAll();
				$noHotels = "Aucun hotel n'a été trouvé avec les propriétées rechercher";
			}
		}
		else{
			$hotels = Hotel::findAll();
		}

		usort($hotels, array('Hotel','sort'));
		usort($typeChambres, array('TypeChambre','sort'));

		if(isset($noHotels))
			return view("welcomePage",["hotels"=> $hotels, "villes" => $villes, "typeChambres" => $typeChambres, "noHotels" => $noHotels]);





		return view("welcomePage",["hotels"=> $hotels, "villes" => $villes, "typeChambres" => $typeChambres]);
	}



}