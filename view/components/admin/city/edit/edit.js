'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#city_form",function() {  
        return cityControlPanel.update('#city_form');
    },function(result) {          
        arikaim.ui.form.showMessage(result.message);        
    });
});