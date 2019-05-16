<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/style.css">
      <title>Mes réservations</title>
      </head>
   <body>
<?php
component("topMenu");
echo "<div class='reservations'>";
echo "<h1>Mes réservations<br></h1>";

if(isset($reservations)){
	if($reservations == null) echo "aucune réservation";
	else{
		foreach($reservations as $reservation){
			echo "<div class='reservation'>";
			echo $hotels[$reservation->num_r]->nom_h."<br>";
			echo $hotels[$reservation->num_r]->adresse_h."<br>";
			echo $hotels[$reservation->num_r]->ville_h."<br>";
			echo "Date d'arrivée : ".date("d/m/Y",strtotime($reservation->dateAr_r))."<br>";
			echo "Date de départ : ".date("d/m/Y",strtotime($reservation->dateDep_r))."<br>";
			echo "Nombre de personnes : ".$reservation->nbPersonnes_r."<br>";
			if($servicesdemander[$reservation->num_r]!=null) echo "Services compris : <br>";
			foreach($servicesdemander[$reservation->num_r] as $service){
				echo $service->nom_s."<br>";
			}
			echo "<p class='prix'>".($reservation->prixTotal_r-($reservation->prixTotal_r*$reservation->reduction_r))."€</p><br>";
			
			if($reservation->etat_r== "ATTENTE_CONFIRMATION"){
				echo "Attente de confirmation<br><br>";
				echo "<a href='/verification/".$reservation->num_r."/".$hotels[$reservation->num_r]->num_h."/confirmation'>Confirmer</a>";
				echo "<a href='/verification/".$reservation->num_r."/".$hotels[$reservation->num_r]->num_h."/annulation'>Annuler</a>";
				echo "<a href='/services/".$reservation->num_r."/".$hotels[$reservation->num_r]->num_h."'>Ajouter un service</a>";
			}
			else if($reservation->etat_r== "CONFIRMATION"){
				echo "Confirmé<br><br>";
				echo "<a href='/verification/".$reservation->num_r."/".$hotels[$reservation->num_r]->num_h."/annulation'>Annuler</a>";
				echo "<a href='/services/".$reservation->num_r."/".$hotels[$reservation->num_r]->num_h."'>Ajouter un service</a>";				
			}
			else if($reservation->etat_r== "ANNULATION"){
				echo "Annulé<br>";
			}
			else if($reservation->etat_r== "FINIE"){
				echo "Passé<br>";
			}
			echo "</div>";
		}
	}
}
echo "</div>";
?>
</body>
</html>