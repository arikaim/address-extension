'use strict';

arikaim.component.onLoaded(function() {

    $('.city-dropdown').on('change',function() {
        var selected = $('.city-dropdown').dropdown("get value");
        
        arikaim.page.loadContent({
            id: 'city_form_content',
            component: 'address::admin.city.form',
            params: { uuid: selected }
        },function(result) {
         
        });
    });    
});