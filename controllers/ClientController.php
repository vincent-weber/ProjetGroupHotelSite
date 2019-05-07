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


    public function moncompte(){
		
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
			}
			
			return view("mesreservations",["reservations" => $reservations, "hotels" => $hotels]);
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
		return redirect("/mesreservations");
	}
}