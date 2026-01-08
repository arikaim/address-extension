'use strict';

arikaim.component.onLoaded(function() {   
  
    $('.country-dropdown').on('change',function() {
        var selected = $('.country-dropdown').dropdown("get value");
        
        arikaim.page.loadContent({
            id: 'country_form_content',
            component: 'address::admin.country.form',
            params: { uuid: selected }
        },function(result) {
            initCountryForm();
        });
    });
    
    function initCountryForm() {
        arikaim.ui.form.addRules("#country_form",{});

        arikaim.ui.form.onSubmit("#country_form",function() {  
            return countryControlPanel.update('#country_form');
        },function(result) {          
            arikaim.ui.form.showMessage(result.message);        
        });
    }
    
    initCountryForm();    
});