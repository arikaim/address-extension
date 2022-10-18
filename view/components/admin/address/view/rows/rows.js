'use strict';

arikaim.component.onLoaded(function() {
    safeCall('addressView',function(obj) {
        obj.initRows();
    },true);    
});