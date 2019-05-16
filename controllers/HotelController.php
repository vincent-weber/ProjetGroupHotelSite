<?php
class HotelController{

	public function index($request) {

		$villes = DB::select("Select distinct(ville_h) from Hotel order by ville_h");
		$typeChambres = TypeChambre::findAll();

		if($request->getNbPostElements() > 0){


			$dateArriver = $request->input("dateArriver");
			$dateDepart = $request->input("dateDepart");

			$ville = $request->input("ville");
			$etatChambre = $request->input("typeChambre");

			if(trim($ville) === ''){
				$ville = "%";
			}

			if(trim($etatChambre) === ''){
				$etatChambre = "%";
			}

			$query = "SELECT num_h,nom_h,ville_h,adresse_h,latitude_h,longitude_h FROM Hotel
			WHERE ville_h LIKE '".$ville."' AND num_h NOT IN (
			SELECT h.num_h
						FROM Hotel h
						JOIN Chambre c ON c.num_h=h.num_h
						CROSS JOIN ReservationChambre rc ON c.num_h=rc.num_h AND c.num_c=rc.num_c
						CROSS JOIN Reservation r ON r.num_r=rc.num_r
						WHERE ('".$dateArriver."' BETWEEN r.dateAr_r AND r.dateDep_r OR '".$dateDepart."' BETWEEN r.dateAr_r AND r.dateDep_r) AND r.etat_r <> 'ANNULATION'  AND c.nom_t LIKE '".$etatChambre."'
						GROUP BY h.num_h
						HAVING COUNT(rc.num_c) + ".$request->input("nbChambres")." > (SELECT COUNT(*) FROM Chambre c2 WHERE h.num_h=c2.num_h GROUP BY c2.num_h))";

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

	public function hotel($numh){
		$hotel = Hotel::findOneWhere("num_h=".$numh);
		$services = DB::select("Select nom_s, prix_s from TypeService where nom_s in (select nom_s from Proposer where num_h =".$numh.")");
		$typechambres = DB::select("Select * from TypeChambre where nom_t in (select distinct(nom_t) from Chambre where num_h=".$numh.")");
		return view("hotel",["hotel"=> $hotel, "services" => $services, "typechambres" => $typechambres]);
	}
	
	public function reserver($numh) {
		if(Session::has("connectedClient"))
        {
			$typechambres = DB::select("Select * from TypeChambre where nom_t in (select distinct(nom_t) from Chambre where num_h=".$numh.")");
            return view("reserver",["num_h" => $numh, "typechambres" => $typechambres]);
        }
        else{
			return redirect("/inscription");
		}
		
	}
	
	public function reservation($request){
		if($request->getNbPostElements() > 0){
			$num_h = $request->input("num_h");
			$nom_t = $request->input("typeChambre");
			$dateDepart = $request->input("dateDepart");
			$dateArriver = $request->input("dateArriver");
			$nbPersonnes = $request->input("nbPersonnes");
			$nbChambres = $request->input("nbChambres");
			$chambresdispo = Chambre::findAllWhere("nom_t='"
				.$nom_t."' and num_h =".$num_h.
				" and num_c not in ( Select num_c from Historique where num_h=".$num_h.
				" and  ('".$dateArriver."' BETWEEN date_deb AND date_fin OR '".$dateDepart."' BETWEEN date_deb AND date_fin))");
			if (count($chambresdispo)<$nbChambres){
				$typechambres = DB::select("Select * from TypeChambre where nom_t in (select distinct(nom_t) from Chambre where num_h=".$num_h.")");
				return view("reserver" ,["num_h" => $num_h, "typechambres" => $typechambres, "error" => "pas assez de chambres disponibles"]);
			}
			$nbLits = TypeChambre::findOneWhere("nom_t='".$nom_t."'");
			if($nbPersonnes>($nbLits->nbLits_t*$nbChambres*2)){
				$typechambres = DB::select("Select * from TypeChambre where nom_t in (select distinct(nom_t) from Chambre where num_h=".$num_h.")");
				return view("reserver" ,["num_h" => $num_h, "typechambres" => $typechambres, "error" => "trop de personnes pour ce nombre de chambres"]);
			}
			
			$typeChambre=TypeChambre::findOneWhere("nom_t='".$nom_t."'");
			
			$reservation = new Reservation;
			$reservation->dateAr_r = $dateArriver;
			$reservation->dateDep_r = $dateDepart;
			$reservation->nbPersonnes_r = $nbPersonnes;
			$reservation->etat_r="ATTENTE_CONFIRMATION";
			$reservation->prixTotal_r=($typeChambre->prix_t*$nbChambres);
			$reservation->reduction_r=0;
			$reservation->num_cl=Session::get("connectedClient")->num_cl;
			try{
				$reservation->save();
			}
			catch(Exception $e){
				$typechambres = DB::select("Select * from TypeChambre where nom_t in (select distinct(nom_t) from Chambre where num_h=".$num_h.")");
				return view("reserver" ,["num_h" => $num_h, "typechambres" => $typechambres, "error" => "réservation échoué"]);
			
			}
			$n=0;
			foreach($chambresdispo as $chambre){
				$reservationChambre = new ReservationChambre;
				$reservationChambre->num_r=$reservation->num_r;
				$reservationChambre->num_h=$num_h;
				$reservationChambre->num_c=$chambre->num_c;
				$historique = new Historique;
				$historique->type_hist="Reservation";
				$historique->date_deb=$dateArriver;
				$historique->date_fin=$dateDepart;
				$historique->num_h=$num_h;
				$historique->num_c=$chambre->num_c;
				try{
					$reservationChambre->save();
					$historique->save();
				}
				catch(Exception $e){
					$typechambres = DB::select("Select * from TypeChambre where nom_t in (select distinct(nom_t) from Chambre where num_h=".$num_h.")");
					return view("reserver" ,["num_h" => $num_h, "typechambres" => $typechambres, "error" => "réservation échoué"]);
				}
				$n=$n+1;
				if($nbChambres==$n)redirect("/mesreservations");
			}
			
		}
	}

}