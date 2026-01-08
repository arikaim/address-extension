'use strict';

arikaim.component.onLoaded(function() {
    $('#map_provider_dropdown').on('change', function() {
        var selected = $(this).val();
    
        arikaim.page.loadContent({
            id: 'map_content',
            component: 'address::map',
            params: { provider: selected }
        });        
    });
});