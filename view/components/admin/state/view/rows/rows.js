'use strict';

arikaim.component.onLoaded(function() {
    safeCall('statesView',function(obj) {
        obj.initRows();
    },true);    
});