'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#country_form",function() {  
        return countryControlPanel.add('#country_form');
    },function(result) {
        countryView.addItem({
            uuid: result.uuid
        });
        
        arikaim.ui.form.clear('#country_form');
        arikaim.ui.form.showMessage(result.message);        
    });
});
