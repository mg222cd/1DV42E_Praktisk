"use strict";

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
}

google.maps.event.addDomListener(window, 'load', initialize);

/*
//Constructor
var Map = function(latitude, longitude) {
    this.latitude = latitude;
    this.longitude = longitude;
    this.infoWindow = undefined;
    this.markers = [];
    var mapOptions = {
        center: new google.maps.LatLng (this.latitude, this.longitude),
    }
    this.map = new google.maps.Map (document.getElementById('map-canvas'), mapOptions);
};
*/


/*

function initialize() {
  var myLatLng = {lat: -25.363, lng: 131.044};

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 4,
    center: myLatLng
  });

  var marker = new google.maps.Marker({
    position: myLatLng,
    map: map,
    title: 'Hello World!'
  });
}


Map.prototype.setMarker = function(location) {
    var that = this;
    var latLng = new google.maps.LatLng (location.latitude, location.longitude);
    var marker = new google.maps.Marker ({
        position: latLng,
        map: this.map,
    });
    this.markers.push(marker);
    google.maps.event.addListener(marker, 'click', function () {
        that.getInfoWindow(location, marker);
    });
};


Map.prototype.deleteMarkers = function() {
    for (var i = 0; i < this.markers.length; i++) {
        this.markers[i].setMap(null);
    }
    this.markers = [];
}

*/