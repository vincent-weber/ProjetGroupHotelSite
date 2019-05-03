$( document ).ready(function() {
    //do your things


    var map = L.map('mapid');
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiZ3JvdXBob3RlbCIsImEiOiJjanY2cGlucDYwM250NGFxcjM4ZWI4encwIn0.2G5aAn1IpSfmmgIJ_V-YhA'
    }).addTo(map);

    var lonLatArray = [];
    var markers = [];

    /*Ajout des longitudes et latitudes de chaque hotel pour centrer la map et afficher les markers*/
    for(var index = 0 ; index < $(".welcomePageHotelLatitude").length;index++){
        var latlon = [$(".welcomePageHotelLatitude").eq(index).text(),$(".welcomePageHotelLongitude").eq(index).text()];
        markers.push(L.marker(latlon).addTo(map));
        lonLatArray.push(latlon)
    }

    map.fitBounds(lonLatArray);

   
    map.on("moveend", function () {
        markers.forEach(marker => {
            var markerLonLat = marker.getLatLng();
            if(!map.getBounds().contains(marker.getLatLng())){
                /*$(".welcomePageHotelLatitude:contains('"+markerLonLat.lat+"')").parent().css("display","none");*/
                $(".welcomePageHotelLatitude:contains('"+markerLonLat.lat+"')").parent().slideUp(300);

            }
            else{
                /*$(".welcomePageHotelLatitude:contains('"+markerLonLat.lat+"')").parent().css("display","block");*/
                $(".welcomePageHotelLatitude:contains('"+markerLonLat.lat+"')").parent().slideDown(300);
            }
        });
    })



});


//TODO Cacher les hotels qui ne sont pas afficher en direct sur la map


//token api js
//pk.eyJ1IjoiZ3JvdXBob3RlbCIsImEiOiJjanY2cGlucDYwM250NGFxcjM4ZWI4encwIn0.2G5aAn1IpSfmmgIJ_V-YhA 
