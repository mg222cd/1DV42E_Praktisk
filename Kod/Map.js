"use strict";
function initialize(){
    var lat = getLat();
    var lng = getLng();

    console.log(lat, lng); // <-- Putput blir "undefined, undefined"

    var myLatLng = { lat:lat, lng:lng };

    var mapOptions = {
        center: new google.maps.LatLng(62.7013, 12.38913),
        zoom: 8
    };
    
    var map = new google.maps.Map(document.getElementById('map-canvas'),
        mapOptions);

    var marker = new google.maps.Marker({
        position : myLatLng,
        map : map
    });
}

function getLat(){
    $.get('./Helpers/Lat.php', function (data){
        console.log(data); //<-- Funkar!
        return data;
    });
}
function getLng(){
    $.get('./Helpers/Lng.php', function (data){
        console.log(data); //<-- Funkar!
        return data;
    });
}

google.maps.event.addDomListener(window, 'load', initialize);