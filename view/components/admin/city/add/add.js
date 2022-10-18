'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#city_form",function() {  
        return cityControlPanel.add('#city_form');
    },function(result) {
        arikaim.ui.form.clear('#city_form');
        arikaim.ui.form.showMessage(result.message);        
    });
});
