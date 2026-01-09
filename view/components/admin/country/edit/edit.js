'use strict';

arikaim.component.onLoaded(function() {   
    arikaim.ui.form.onSubmit("#country_form",function() {  
        return countryControlPanel.update('#country_form');
    },function(result) {   
        countryView.updateItem(result.uuid);            
        arikaim.ui.form.showMessage(result.message);        
    });
});