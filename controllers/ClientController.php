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


}