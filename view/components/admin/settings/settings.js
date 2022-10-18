'use strict';

arikaim.component.onLoaded(function() {
    arikaim.events.on('driver.config',function(element,name,category) {
        return drivers.loadConfig(name,'settings_content');           
    },'driverConfig'); 

    $('#drivers_dropdown').dropdown({
        onChange: function(value) {                               
            options.save('map.default.driver',value);       
        }
    });
});