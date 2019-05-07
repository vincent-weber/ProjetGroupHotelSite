<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="../../../css/style.css">
      <title>Vérification</title>
      </head>
   <body>
<?php
component("topMenu");
echo "<div class='reservations'>";
if(isset($confirmation)){
	echo "<h2>Voulez-vous confirmer cette réservation ?</h2>";
}
if(isset($annulation)){
	echo "<h2>Voulez-vous annuler cette réservation ?</h2>";
}
echo "<div class='reservation'>";

echo $hotel->nom_h."<br>";
echo $hotel->adresse_h."<br>";
echo $hotel->ville_h."<br>";
echo "Date d'arrivée : ".date("d/m/Y",strtotime($reservation->dateAr_r))."<br>";
echo "Date de départ : ".date("d/m/Y",strtotime($reservation->dateDep_r))."<br>";
echo "Nombre de personnes : ".$reservation->nbPersonnes_r."<br>";
echo "<p class='prix'>".$reservation->prixTotal_r."€</p><br>";
if(isset($confirmation)){
	echo "<a href='/confirmation/".$reservation->num_r."'>Confirmer</a>";
}
if(isset($annulation)){
	echo "<a href='/annulation/".$reservation->num_r."'>Annuler</a>";
}

echo "<a href='/mesreservations'>Retour</a><br>";
?>
</div>
</div>
</body>
</html>