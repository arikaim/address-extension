'use strict';

arikaim.component.onLoaded(function() {
    $('#map_provider_dropdown').dropdown({
        onChange: function(selected) {
            arikaim.page.loadContent({
                id: 'map_content',
                component: 'address::map',
                params: { provider: selected }
            }); 
        }
    });
});