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

        this.setItemsSelector('city_rows');
        this.setItemComponentName('address::admin.city.view.item');

        arikaim.ui.loadComponentButton('.city-action');

        search.init({
            id: 'city_rows',
            component: 'address::admin.city.view.rows',
            event: 'city.search.load'
        },'city');
        
        arikaim.events.on('city.search.load',function(result) {     
            arikaim.ui.getComponent('city_paginator').reload();           
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
            var message = arikaim.ui.template.render(cityView.getMessage('remove.content'),{ title: title });
            
            arikaim.ui.getComponent('confirm_delete').open(function() {
                cityControlPanel.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('#row_' + result.uuid);     
                });
            },message);
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