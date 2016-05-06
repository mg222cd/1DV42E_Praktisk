"use strict";
function initialize () {
    var lat;
    var lng;

    $.get('./Helpers/Lat.php', function ( data ) {
        lat = data;
        console.log(lat);
    });

    $.get('./Helpers/Lng.php', function ( data ) {
        lng = data;
        console.log(lng);
    });

    console.log(lat, lng);

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

google.maps.event.addDomListener(window, 'load', initialize);

/*
function initialize () {
    var myLatLng = {lat: 62.7013, lng: 12.38913};

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

    $.get('./Helpers/Lat.php', function ( data ) {
    console.log(data)
    });
}

google.maps.event.addDomListener(window, 'load', initialize);
*/
