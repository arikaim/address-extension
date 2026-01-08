'use strict';

function AddressApi() {

    this.update = function(formId, onSuccess, onError) {
        return arikaim.put('/api/address/update',formId,onSuccess,onError);          
    };

    this.updateMap = function(uuid, latitude, longitude, onSuccess, onError) {
        return arikaim.put('/api/address/map/update',{
            uuid: uuid,
            latitude: latitude,
            longitude: longitude
        },onSuccess,onError);          
    };
}

var addressApi = new AddressApi();