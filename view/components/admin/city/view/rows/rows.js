'use strict';

arikaim.component.onLoaded(function() {
    safeCall('cityView',function(obj) {
        obj.initRows();
    },true);    
});