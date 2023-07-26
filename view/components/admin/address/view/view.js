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

        paginator.init('address_rows');   
        
        search.init({
            id: 'address_rows',
            component: 'address::admin.address.view.rows',
            event: 'address.search.load'
        },'address');
        
        arikaim.events.on('address.search.load',function(result) {      
            paginator.reload();
            self.initRows();    
        },'addressSearch');  

    };

    this.initRows = function() {    
        $('.status-dropdown').dropdown({
            onChange: function(value) {
                var uuid = $(this).attr('uuid');
                addressControlPanel.setStatus(uuid,value);               
            }
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

        arikaim.ui.button('.edit-button',function(element) {
            var uuid = $(element).attr('uuid');
            arikaim.ui.setActiveTab('#edit_address','.address-tab-item');

            arikaim.page.loadContent({
                id: 'address_content',
                component: 'address::admin.address.edit',
                params: { uuid: uuid }
            }); 
        });

        arikaim.ui.button('.details-button',function(element) {
            var uuid = $(element).attr('uuid');
            $('#address_details').show();

            arikaim.page.loadContent({
                id: 'address_details',
                component: 'address::admin.address.details',
                params: { uuid: uuid }
            }); 
        });

        arikaim.ui.button('.map-button',function(element) {
            var uuid = $(element).attr('uuid');
            $('#address_details').show();

            arikaim.page.loadContent({
                id: 'address_details',
                component: 'address::admin.address.map',
                params: { uuid: uuid }
            }); 
        });
    }
}

var addressView = createObject(AddressView,ControlPanelView);

arikaim.component.onLoaded(function() {
    addressView.init();   
});