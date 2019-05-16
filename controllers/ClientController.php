<?php
class ClientController{

	public function connexion($request) {
        if(Session::has("connectedClient"))
        {
            return redirect("/");
        }
        else{
            if($request->getNbPostElements() > 0){
                $client = Client::findOneWhere("pseudo = '".$request->input("username")."' AND motdepasse = '".hash('md5',$request->input("password"))."'");
                if($client !== null){
                    Session::put("connectedClient",$client);
                    return redirect("/");
                }
                else{
                    return view("connexion",["error" => "mot de passe ou identifiant incorrect"]);
                }
            }
        }
		return view("connexion");
    }
    

    public function inscription($request){
        if(Session::has("connectedClient")){
            Session::unset();
        }
        else{
            if($request->getNbPostElements() > 0){



                $client = new Client;
                $client->nom_cl = strtoupper($request->input("nom"));
                $client->prenom_cl = ucfirst(strtolower($request->input("prenom")));
                $client->nomEntreprise = $request->input("groupe");
                $client->telephone_cl = $request->input("telephone");
                $client->mail_cl = $request->input("email");
                $client->pseudo = $request->input("username");
                $client->motdepasse = hash('md5',$request->input("password"));
                try{
                    $client->save();
                    Session::put("connectedClient",$client);
                    return redirect("/");
                }
                catch(Exception $e){
                    $matches = explode("'",$e->errorInfo[2]);
                    return view("inscription" ,["error" => "".$matches[1]." est déja utilisé"]);
                }     
        }

        return view("inscription");
    }
}

    public function deconnexion(){

        Session::unset("connectedClient");
        return redirect("/");
    }

    
    public function monCompte(){
		$client = Session::get("connectedClient");
        return view("monCompte",["client"=>$client]);
    }
	
	public function editer(){
		$client = Session::get("connectedClient");
        return view("monCompte",["client"=>$client,"editer"=>"oui"]);
    }
	public function modifierprofil($request){
			$client = Session::get("connectedClient");
            if($request->getNbPostElements() > 0){
				if($client->nom_cl != strtoupper($request->input("nom"))) $set = $set."nom_cl='".strtoupper($request->input("nom"))."', ";
                if($client->prenom_cl != ucfirst(strtolower($request->input("prenom")))) $set = $set."prenom_cl='".ucfirst(strtolower($request->input("prenom")))."', ";
                if($client->nomEntreprise != $request->input("groupe")) $set = $set."nomEntreprise='".$request->input("groupe")."', ";
                if($client->telephone_cl != $request->input("telephone")) $set = $set."telephone_cl='".$request->input("telephone")."', ";
                if($client->mail_cl != $request->input("email")) $set = $set."mail_cl='".$request->input("email")."', ";
                if($client->motdepasse != "") $set = $set."motdepasse='".hash('md5',$request->input("password"))."', ";
                if($set==null)return redirect("/monCompte");
				$set=substr($set,0,strlen($set)-2);
				$client->update($set,"num_cl=".$client->num_cl);
				$client = Client::findOneWhere("num_cl=".$client->num_cl);
				Session::put("connectedClient",$client);
				return redirect("/moncompte");
			}
        return view("monCompte",["client"=>$client,"editer"=>"oui"]);
    }
    

	public function mesreservations(){
		if(Session::has("connectedClient"))
        {
			$client = Session::get("connectedClient");
            $reservations = Reservation::findAllWhere("num_cl=".$client->num_cl." ORDER BY dateAr_r DESC");
			foreach($reservations as $reservation){
				$reservation_chambre = ReservationChambre::findOneWhere("num_r=".$reservation->num_r);
				if($reservation_chambre !=null){
					$hotels[$reservation->num_r] = Hotel::findOneWhere("num_h=".$reservation_chambre->num_h);
				}
				$servicesdemander[$reservation->num_r]=DB::select("Select * from Demander where num_r=".$reservation->num_r);
			}
			
			return view("mesreservations",["reservations" => $reservations, "hotels" => $hotels, "servicesdemander" => $servicesdemander]);
        }
		else{
			return redirect("/");
		}
	}
	public function verification($num_r, $num_h,$type){
		$reservation = Reservation::findOneWhere("num_r=".$num_r);
		$hotel = Hotel::findOneWhere("num_h=".$num_h);
		if($type=="annulation"){
			return view("verification",["reservation" => $reservation, "hotel" => $hotel, "annulation" => "oui"]);
		}
		else if($type=="confirmation"){
			return view("verification",["reservation" => $reservation, "hotel" => $hotel, "confirmation" => "oui"]);
		}
	}
	public function confirmation($num_r){
		$reservation = Reservation::findOneWhere("num_r=".$num_r);
		$reservation->update("etat_r='CONFIRMATION'","num_r =".$num_r);
		return redirect("/mesreservations");
	}
	public function annulation($num_r){
		$reservation = Reservation::findOneWhere("num_r=".$num_r);
		$reservation->update("etat_r='ANNULATION'","num_r =".$num_r);
		$reservationchambres = ReservationChambre::findAllWhere("num_r=".$num_r);
		foreach($reservationchambres as $chambres){
			$historique = Historique::findOneWhere("num_c=".$chambres->num_c." and date_deb='".$reservation->dateAr_r."' and date_fin='".$reservation->dateDep_r."'");
			$historique->delete("num_c=".$chambres->num_c." and date_deb='".$reservation->dateAr_r."' and date_fin='".$reservation->dateDep_r."'");
		}
		return redirect("/mesreservations");
	}
	
	public function services($num_r,$num_h){
		$reservation = Reservation::findOneWhere("num_r=".$num_r);
		$hotel = Hotel::findOneWhere("num_h=".$num_h);
		$services = DB::select("Select nom_s, prix_s from TypeService where nom_s in (select nom_s from Proposer where num_h =".$hotel->num_h.
		" and nom_s not in(select nom_s from Demander where num_r=".$reservation->num_r."))");
		return view("services",['reservation' => $reservation, 'hotel'=>$hotel, 'services' => $services]);
	}
	
	public function ajoutService($nom_s,$num_r){
		$reservation = Reservation::findOneWhere("num_r=".$num_r);
		$service = DB::select("Select nom_s, prix_s from TypeService where nom_s='".$nom_s."'");
		$demander = DB::insert("insert into Demander (num_r,nom_s) VALUES (".$num_r.",'".$nom_s."')"); 
		$datetime1 = new DateTime($reservation->dateDep_r);
		$datetime2 = new DateTime($reservation->dateAr_r);
		$interval = $datetime1->diff($datetime2);
		$reservation->update("prixTotal_r=".($reservation->prixTotal_r+($service[0]->prix_s*$reservation->nbPersonnes_r*$interval->format('%a'))),"num_r=".$reservation->num_r);
		
		redirect("/mesreservations");
	}
}