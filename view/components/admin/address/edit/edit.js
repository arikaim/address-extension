'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#address_form",function() {  
        return addressControlPanel.update('#address_form');
    },function(result) {
        arikaim.ui.form.showMessage(result.message);        
    });
});
