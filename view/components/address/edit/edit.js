'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#address_form",function() {  
        return addressControlPanel.update('#address_form');
    },function(result) {
        arikaim.events.emit('address.update',result.uuid);
        arikaim.ui.form.showMessage(result.message);        
    });
});
