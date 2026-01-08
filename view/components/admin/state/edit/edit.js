'use strict';

arikaim.component.onLoaded(function() {  
    $('.state-dropdown').dropdown({
        onChange: function(value, text, choice) { 
            arikaim.page.loadContent({
                id: 'state_form_content',
                component: 'address::admin.state.form',
                params: { uuid: value }
            },function(result) {
                initStateForm();
            });
        }
    });
    
    function initStateForm() {
        arikaim.ui.form.onSubmit("#state_form",function() {  
            return statesControlPanel.update('#state_form');
        },function(result) {          
            arikaim.ui.form.showMessage(result.message);        
        });
    }
    
    initStateForm();    
});