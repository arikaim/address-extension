/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
 */
'use strict';

function StatesControlPanel() {
    
    this.add = function(data, onSuccess, onError) {
        return arikaim.post('/api/admin/address/state/add',data,onSuccess,onError);          
    };

    this.update = function(data, onSuccess, onError) {
        return arikaim.put('/api/admin/address/state/update',data,onSuccess,onError);          
    };

    this.delete = function(uuid, onSuccess, onError) {
        return arikaim.delete('/api/admin/address/state/delete/' + uuid,onSuccess,onError);          
    };

    this.setStatus = function(uuid, status, onSuccess, onError) {
        var data = {
            uuid: uuid,
            status: status
        };

        return arikaim.put('/api/admin/address/state/status',data,onSuccess,onError);          
    };  
}

var statesControlPanel = new StatesControlPanel();

arikaim.component.onLoaded(function() {
    arikaim.ui.tab('.states-tab-item','states_content');
});
