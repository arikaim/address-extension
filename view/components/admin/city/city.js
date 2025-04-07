/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function CityControlPanel() {
    
    this.add = function(data, onSuccess, onError) {
        return arikaim.post('/api/admin/address/city/add',data,onSuccess,onError);          
    };

    this.update = function(data, onSuccess, onError) {
        return arikaim.put('/api/admin/address/city/update',data,onSuccess,onError);          
    };

    this.delete = function(uuid, onSuccess, onError) {
        return arikaim.delete('/api/admin/address/city/delete/' + uuid,onSuccess,onError);          
    };

    this.setStatus = function(uuid, status, onSuccess, onError) {
        var data = {
            uuid: uuid,
            status: status
        };

        return arikaim.put('/api/admin/address/city/status',data,onSuccess,onError);          
    };   
}

var cityControlPanel = new CityControlPanel();

arikaim.component.onLoaded(function() {
    arikaim.ui.tab('.city-tab-item','city_content');
});
