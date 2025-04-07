/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function CountryControlPanel() {
  
    this.add = function(data, onSuccess, onError) {
        return arikaim.post('/api/admin/address/country/add',data,onSuccess,onError);          
    };

    this.delete = function(uuid, onSuccess, onError) {
        return arikaim.delete('/api/admin/address/country/delete/' + uuid,onSuccess,onError);          
    };

    this.update = function(data, onSuccess, onError) {
        return arikaim.put('/api/admin/address/country/update',data, onSuccess, onError);          
    };

    this.setStatus = function(uuid, status, onSuccess, onError) {
        var data = {
            uuid: uuid,
            status: status
        };
        
        return arikaim.put('/api/admin/address/country/status',data,onSuccess,onError);          
    };   
}

var countryControlPanel = new CountryControlPanel();

arikaim.component.onLoaded(function() {
    arikaim.ui.tab('.country-tab-item','country_content');      
});