'use strict';

arikaim.component.onLoaded(function() {
    arikaim.ui.button('.close-button',function(element) {
        $('#address_details').fadeOut(400);
    });
});