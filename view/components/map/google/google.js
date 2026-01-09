'use strict';

var map;
var currentPositionMarker;
var googleMapsLoaded = false;

function initGoogleMap(latitude, longitude, elementSelector) {   
    googleMapsLoaded = true;
    elementSelector = getDefaultValue(elementSelector,'map');
    var element = document.getElementById(elementSelector); 

    if (isEmpty(latitude) == true && isEmpty(longitude) == true) {
        latitude = $('#' + elementSelector).attr('latitude').trim();
        longitude = $('#' + elementSelector).attr('longitude').trim();
    }

    if (isEmpty(latitude) == true || isEmpty(longitude) == true) {
        // get current location       
        Geolocation.getCurrentPosition(function(result) {

            console.log('set currenct empty');
            map = new google.maps.Map(element, {
                center: { lat: result.lat, lng: result.lng },
                zoom: 8,
            }); 
            return map;

        },function(error) {  
                 
            map = new google.maps.Map(element, {
                center: { lat: 0, lng: 0 },
                zoom: 8,
            }); 
           
            return map;
        });
    } else {
        console.log('set currenct : ' + latitude + ' : ' + longitude);
        map = new google.maps.Map(element,{
            center: { 
                lat: parseFloat(latitude), 
                lng: parseFloat(longitude) 
            },
            zoom: 8,
        }); 

        return map;
    }
};

arikaim.component.onLoaded(function() {
    arikaim.ui.button('.current-position',function(element) {
        Geolocation.getCurrentPosition(function(result) {
            
        },function(error) {          
            arikaim.page.toastMessage({
                message: error.message,
                class: 'error'
            });
        });
    });

    arikaim.component.loadLibrary('maps',function(result) {          
        var token = $('#map').attr('token');
        var url = (isEmpty(token) == true) ? '?sensor=false' : '?key=' + token;

        if (googleMapsLoaded == false) {
            arikaim.includeScript('https://maps.googleapis.com/maps/api/js' + url + '&callback=initGoogleMap',function(result) {
                console.log('loaded maps:google');    
            });
        } else {
            // set to position 
            initGoogleMap();
        }
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