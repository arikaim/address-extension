'use strict';

var map;
var currentPositionMarker;

function initMapBoxMap(lat,lng,token) {
    var map = L.map('map').setView([lat,lng],13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=' + token, {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: token
    }).addTo(map);

    return map;
}

arikaim.component.onLoaded(function() {

    arikaim.ui.button('.current-position',function(element) {
        Geolocation.getCurrentPosition(function(result) {
            console.log(result);
        },function(error) {          
            arikaim.page.toastMessage({
                message: error.message,
                class: 'error'
            });
        });
    });

    arikaim.component.loadLibrary('maps',function(result) {  
       
        arikaim.component.loadLibrary('maps:openstreet',function(result) {    
            console.log('loaded maps:openstreet');    
               
            var token = $('#map').attr('token');
            var latitude = $('#map').attr('latitude');
            var longitude = $('#map').attr('longitude');
    
            if (isEmpty(latitude) == false && isEmpty(longitude) == false) {
                map = initMapBoxMap(latitude,longitude,token);
                currentPositionMarker = L.marker([latitude,longitude]).addTo(map);
                return map;
            } 
    
            // get current location       
            Geolocation.getCurrentPosition(function(result) {
                map = initMapBoxMap(result.lat,result.lng,token);
                currentPositionMarker = L.marker([result.lat,result.lng]).addTo(map);
            },function(error) {            
                arikaim.page.toastMessage({
                    message: error.message,
                    class: 'error'
                });
                map = initMapBoxMap(0,0,token);
                currentPositionMarker = null;
            });
        });     
    },function(error) {
        arikaim.ui.loadComponent({
            mountTo: 'map_content',
            component: 'system:admin.alert.error',
            params: {
                message: 'Library maps not installed'
            }
        });
    });
});