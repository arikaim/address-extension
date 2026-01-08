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
        arikaim.ui.loadComponentButton('.create-address');

        search.init({
            id: 'address_rows',
            component: 'address::admin.address.view.rows',
            event: 'address.search.load'
        },'address');
        
        arikaim.events.on('address.search.load',function(result) {      
            paginator.reload();
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

            modal.confirmDelete({ 
                title: self.getMessage('remove.title'),
                description: message
            },function() {
                addressControlPanel.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('#row_' + result.uuid);     
                });
            });
        });
    }
}

var addressView = createObject(AddressView,ControlPanelView);

arikaim.component.onLoaded(function() {
    addressView.init();   
});