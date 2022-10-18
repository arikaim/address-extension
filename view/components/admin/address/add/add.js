'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#address_form",function() {  
        return addressControlPanel.add('#address_form');
    },function(result) {
        arikaim.ui.form.clear('#address_form');
        arikaim.ui.form.showMessage(result.message);        
    });
});
