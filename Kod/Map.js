"use strict";
function initialize(){
    var lat = '';
        $.ajax({ type: "GET",   
         url: "./Helpers/Lat.php",
         contentType: "text",   
         async: false,
         success : function(text)
         {
             lat = text;
         }
    });
    

    var lng = '';
        $.ajax({ type: "GET",   
         url: "./Helpers/Lng.php",
         contentType: "text",    
         async: false,
         success : function(text)
         {
             lng = text;
         }
    });    

    //gör om datatyp från string till float
    lat = parseFloat(lat);
    lng = parseFloat(lng);

    var myLatLng = { lat:lat, lng:lng};

    var mapOptions = {
        center: new google.maps.LatLng(lat, lng),
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