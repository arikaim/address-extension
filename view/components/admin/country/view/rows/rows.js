'use strict';

arikaim.component.onLoaded(function() {
    safeCall('countryView',function(obj) {
        obj.initRows();
    },true);    
});