# Group Hotel Site

 - Ajouter Route

 Dans routes/routes.php

		Route::get("/exemple" , "ExempleController@method");
		Route::get("/exemple/{id}" , "ExempleController@methodWithParams");
		Route::get("/exemple/{id}/{param2}" , "ExempleController@methodWithParams2");
On peux ajouter autant de paramètres que l'on veut tant qu'il sont séparer pas des "/" et entourer pas des "{}"
	
	Route::post("/exemple/save" , "ExempleController@methodSave");
	
 - Ajouter Controller

 Dans le dossier controllers

        class ExempleController {
		    public function method(){
		    	// DoYourThings
		    	return view("myView1", ["parameterOfView1" => "ValueParameterView"]);
		    }
    
		    public function methodWithParams($id){
		    	// DoYourThings
		    	//Use $id if u want
		    	return view("myView1");
		    }
		    
		    public function methodWithParams2($id, $param2){
		    	// DoYourThings
		    	//Use $id and $param2 if u want
		    	return view("myView3");
		    }
    
		    public function methodSave(){
		    	// doFormThings
		    	return redirect("myView4");
		    }
		}
	

 - Ajouter une Vue

Cree fichier myView1.php dans le dossier views

    <?php 
    
    //Do your page
	Possibiliter d'utiliser les variables passée depuis "return view("myView1", ["parameterOfView1" => "ValueParameterView"]);"
	echo $parameterOfView1; // affiche ValueParameterView


- Faire une request

DB::select([YOUR QUERY]); // j'crois c'est pas fini

DB::insert([YOUR QUERY]); // return l'id inserer enfin je crois

