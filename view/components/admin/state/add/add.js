'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#state_form",function() {  
        return statesControlPanel.add('#state_form');
    },function(result) {
        arikaim.ui.form.clear('#state_form');
        arikaim.ui.form.showMessage(result.message);        
    });
});
