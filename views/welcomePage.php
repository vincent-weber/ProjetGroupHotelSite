<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      

      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
      <link rel="stylesheet" href="css/style.css">

      <title>Group Hotel</title>
      <script src="js/jquery.js"></script>
      <script src="js/jquery-ui.js"></script>      
      <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
   
   </head>
   <body>

   <?php component("topMenu"); ?>


   <form id="welcomPageForm" action="/" method="post" >
   <select name="typeChambre">
   <option value="">-- Chambre --</option>
   <?php
      foreach($typeChambres as $typeChambre){
         if(isset($_POST["typeChambre"]) && $typeChambre->nom_t == $_POST["typeChambre"])
            echo "<option value='$typeChambre->nom_t' selected>$typeChambre->nom_t - $typeChambre->prix_t €</option>";
         else
            echo "<option value='$typeChambre->nom_t'>$typeChambre->nom_t - $typeChambre->prix_t €</option>";
      }
   ?>

   </select>

   <input list="villes" name="ville" placeholder="Ville" <?php if(isset($_POST["ville"])) { echo "value='".$_POST["ville"]."'"; } ?> >
   <datalist id="villes">
   <option value="">- - -</option>

   <?php
      foreach($villes as $ville){
            echo "<option value='$ville->ville_h'>$ville->ville_h</option>";
      }
   ?>

   </datalist>

   <input type="number" name="nbChambres" width="50px" placeholder="Chambres" min="1" <?php if(isset($_POST["nbChambres"])) { echo "value='".$_POST["nbChambres"]."'"; }else{ echo "value='1'";} ?> required>

   <input type="date" name="dateArriver" <?php echo "min='".date("Y-m-d")."'"; if(isset($_POST["dateArriver"])){echo "value = '".$_POST["dateArriver"]."'";}else{echo "value = '".date("Y-m-d")."'";} ?> required>

   à 

   <input type="date" name="dateDepart" <?php echo "min='".date("Y-m-d",strtotime('tomorrow'))."'"; if(isset($_POST["dateDepart"])){echo "value = '".$_POST["dateDepart"]."'";}else{echo "value = '".date("Y-m-d",strtotime('tomorrow'))."'";} ?> required>
      <input type="submit" value="Rechercher">

   </form>

      <div id="mapid"></div>


<?php


echo "<div id='welcomePageHotels'>\n";
if(isset($noHotels))
      echo "<div class='noHotelsFound'>$noHotels</div>";

foreach($hotels as $hotel){
echo <<<HTL
<div class="welcomePageHotel">
   <a href='/hotel/$hotel->num_h'><div class="welcomePageHotelNom">$hotel->nom_h</div></a>
   <div class="welcomePageHotelVille">$hotel->ville_h</div>
   <div class="welcomePageHotelAdresse">$hotel->adresse_h</div>
   <div class="welcomePageHotelLatitude">$hotel->latitude_h</div>
   <div class="welcomePageHotelLongitude">$hotel->longitude_h</div>
</div>
HTL;
}
echo "</div>";
?>
      <script src="js/map.js"></script>
   </body>
</html>