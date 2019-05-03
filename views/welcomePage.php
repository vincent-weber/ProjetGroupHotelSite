<!doctype html>
<html lang="fr">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/style.css">
      <title>Group Hotel</title>
      <script src="js/jquery.js"></script>
      <script src="js/jquery-ui.js"></script>
      <link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
      <script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js" integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg==" crossorigin=""></script>
   </head>
   <body>

   <?php component("topMenu"); ?>
      <div id="mapid"></div>
<?php
echo "      <div id='welcomePageHotels'>\n";
foreach($hotels as $hotel){
echo <<<HTL
<div class="welcomePageHotel">
   <div class="welcomePageHotelNom">$hotel->nom_h</div>
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