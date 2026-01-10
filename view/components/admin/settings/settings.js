'use strict';

arikaim.component.onLoaded(function() {
    arikaim.events.on('driver.config',function(element,name,category) {
        return drivers.loadConfig(name,'driver_settings_content');           
    },'driverConfig'); 

    $('#drivers_dropdown').on('change', function() {
        var value = $(this).val();
        options.save('map.default.driver',value);              
    });
});