'use strict';

arikaim.component.onLoaded(function() {     
    arikaim.ui.form.onSubmit("#state_form",function() {  
        return statesControlPanel.update('#state_form');
    },function(result) {          
        statesView.updateItem(result.uuid);
        arikaim.ui.form.showMessage(result.message);        
    });   
});