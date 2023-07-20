'use strict';

function AddressApi() {

    this.update = function(formId, onSuccess, onError) {
        return arikaim.put('/api/address/update',formId,onSuccess,onError);          
    };

    this.updateMap = function(latitude, longitude, onSuccess, onError) {
        return arikaim.put('/api/address/map/update',{
            latitude: latitude,
            longitude: longitude
        },onSuccess,onError);          
    };
}

var addressApi = new AddressApi();