<link rel="stylesheet" href="https://unpkg.com/leaflet@1.4.0/dist/leaflet.css"
   integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA=="
   crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.4.0/dist/leaflet.js"
   integrity="sha512-QVftwZFqvtRNi0ZyCtsznlKSWOStnDORoefr1enyq5mVL4tmKB3S/EnC3rRJcxCPavG10IcrVGSmPh6Qw5lwrg=="
   crossorigin=""></script>
</head>
<body>

<div id="mapid"></div>
<?php
/*
echo "Welcome Page";*/

//var_dump($hotels);
echo "<div id='welcomePageHotels'>";
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

//Fait en "dur"
?>



