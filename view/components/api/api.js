'use strict';

function AddressApi() {

    this.update = function(formId, onSuccess, onError) {
        return arikaim.put('/api/address/update',formId,onSuccess,onError);          
    };
}

var addressApi = new AddressApi();