'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.form.addRules('#address_form',{});

    arikaim.ui.button('.add-custom-city',function(element) {
        arikaim.ui.hide('#city_input');
        arikaim.ui.show('#custom_city_input');          
    });

    arikaim.ui.button('.cancel-custom-city',function(element) {       
        arikaim.ui.hide('#custom_city_input');
        arikaim.ui.show('#city_input');  
        $('#custom_city').val('');          
    });
});