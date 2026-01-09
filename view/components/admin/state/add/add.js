'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.onSubmit("#state_form",function() {  
        return statesControlPanel.add('#state_form');
    },function(result) {
        statesView.addItem({
            uuid: result.uuid
        });
        
        arikaim.ui.form.clear('#state_form');
        arikaim.ui.form.showMessage(result.message);        
    });
});
