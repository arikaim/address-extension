/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
*/
'use strict';

function AddressView() {
    var self = this;

    this.init = function() {
        this.loadMessages('address::admin.address');
        
        this.setItemsSelector('address_rows');
        this.setItemComponentName('address::admin.address.view.item');

        arikaim.ui.loadComponentButton('.create-address');

        search.init({
            id: 'address_rows',
            component: 'address::admin.address.view.rows',
            event: 'address.search.load'
        },'address');
        
        arikaim.events.on('address.search.load',function(result) {    
            // reload paginator          
            arikaim.ui.getComponent('address_paginator').reload();         
            self.initRows();    
        },'addressSearch');  

        this.initRows();  
    };

    this.initRows = function() {    
        arikaim.ui.loadComponentButton('.address-action');

        $('.status-dropdown').on('change', function() {
            var value = $(this).val();
            var uuid = $(this).attr('uuid');
            
            addressControlPanel.setStatus(uuid,value);               
        });

        arikaim.ui.button('.delete-button',function(element) {
            var uuid = $(element).attr('uuid');
            var title = $(element).attr('data-title');
            var message = arikaim.ui.template.render(self.getMessage('remove.content'),{ title: title });

            arikaim.ui.getComponent('confirm_delete').open(function() {
                addressControlPanel.delete(uuid,function(result) {
                    self.deleteItem(result.uuid);     
                });
            },message);
        });
    }
}

var addressView = createObject(AddressView,ControlPanelView);

arikaim.component.onLoaded(function() {
    addressView.init();   
});