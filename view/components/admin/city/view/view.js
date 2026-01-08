/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
*/
'use strict';

function CityView() {
    var self = this;

    this.init = function() {
        this.loadMessages('address::admin.city');
        arikaim.ui.loadComponentButton('.city-action');

        search.init({
            id: 'city_rows',
            component: 'address::admin.city.view.rows',
            event: 'city.search.load'
        },'city');
        
        arikaim.events.on('city.search.load',function(result) {      
            paginator.reload();
            self.initRows();    
        },'citySearch');   
    };

    this.initRows = function() {    
        $('.status-dropdown').on('change', function() {
            var value = (this).val();
            var uuid = $(this).attr('uuid');

            cityControlPanel.setStatus(uuid,value);                          
        });

        arikaim.ui.button('.delete-button',function(element) {
            var uuid = $(element).attr('uuid');
            var title = $(element).attr('data-title');
            var message = arikaim.ui.template.render(self.getMessage('remove.content'),{ title: title });
            
            modal.confirmDelete({ 
                title: self.getMessage('remove.title'),
                description: message
            },function() {
                cityControlPanel.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('#row_' + result.uuid);     
                });
            });
        });

        arikaim.ui.button('.edit-button',function(element) {
            var uuid = $(element).attr('uuid');

            arikaim.page.loadContent({
                id: 'city_details',
                component: 'address::admin.city.edit',
                params: { uuid: uuid }
            }); 
        });
    }
}

var cityView = createObject(CityView,ControlPanelView);

arikaim.component.onLoaded(function() {
    cityView.init();   
});