'use strict';

arikaim.component.onLoaded(function() {

    $('.city-dropdown').on('change',function() {
        var selected = $('.city-dropdown').dropdown("get value");
        
        arikaim.page.loadContent({
            id: 'city_form_content',
            component: 'address::admin.city.form',
            params: { uuid: selected }
        },function(result) {
            initCityForm();
        });
    });
 
    function initCityForm() {
        arikaim.ui.form.onSubmit("#city_form",function() {  
            return cityControlPanel.update('#city_form');
        },function(result) {          
            arikaim.ui.form.showMessage(result.message);        
        });
    }
    
    initCityForm();    
});