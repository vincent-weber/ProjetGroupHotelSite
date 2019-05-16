<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../../../css/style.css">
      <title>Liste des services</title>
      </head>
   <body>
<?php
component("topMenu");
echo "<div class='reservations'>";
echo "<h2>Services proposés par l'hôtel</h2>";
echo $hotel->nom_h."<br>";
echo $hotel->adresse_h."<br>";
echo $hotel->ville_h."<br>";
echo "<div class='reservation'>";

if($services[0]==null) echo"Aucun service disponible<br><br>";
foreach($services as $service){
	echo $service->nom_s." : ".$service->prix_s*$reservation->nbPersonnes_r. "€/jour<br><br>";
	echo"<a href='/ajoutService/".$service->nom_s."/".$reservation->num_r."'>Ajouter</a><br><br>"; 
}


echo "<a href='/mesreservations'>Retour</a><br>";
?>
</div>
</div>
</body>
</html>