<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../css/style.css">
      <title>Fiche Hôtel</title>
      </head>
   <body>
<?php
component("topMenu");
echo "<div class='reservations'>";
echo "<div class='reservation'>";
echo "<h1>".$hotel->nom_h."<br></h1>";
echo $hotel->adresse_h."<br>";
echo $hotel->ville_h."<br><br>";
echo "<h2>Type des chambres<br><br></h2>";
foreach($typechambres as $typechambre){
	echo "<h3>".$typechambre->nom_t."</h3><br>";
	echo "Prix : ".$typechambre->prix_t."€<br>";
	echo "Nombre de lits : ".$typechambre->nbLits_t."<br>";
	if($typechambre->tv_t ==1) echo "TV : oui<br>";
	else echo "TV : non<br>";
	if($typechambre->telephone_t ==1) echo "Téléphone : oui<br>";
	else echo "Téléphone : non<br>";
	echo "<br>";
}
if($services[0]!= null) echo "<h2>Services proposés<br></h2>";
foreach($services as $service){
	echo $service->nom_s." : ". $service->prix_s."€<br>";
}
echo "<a href='/reserver/".$hotel->num_h."'>Réserver</a>";
echo "</div>";
echo "</div>";
?>
</body>
</html>