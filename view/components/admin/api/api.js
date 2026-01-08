function AddressControlPanel() {
    
    this.add = function(data, onSuccess, onError) {
        return arikaim.post('/api/admin/address/add',data,onSuccess,onError);          
    };

    this.delete = function(uuid, onSuccess, onError) {
        return arikaim.delete('/api/admin/address/delete/' + uuid,onSuccess,onError);          
    };

    this.update = function(data, onSuccess, onError) {
        return arikaim.put('/api/admin/address/update',data,onSuccess,onError);          
    };

    this.setStatus = function(uuid, status, onSuccess, onError) {
        var data = {
            uuid: uuid,
            status: status
        };
        
        return arikaim.put('/api/admin/address/status',data,onSuccess,onError);          
    };
}

var addressControlPanel = new AddressControlPanel();
