/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
*/
'use strict';

function StatesView() {
    var self = this;

    this.init = function() {   
        this.loadMessages('address::admin.state');

        this.setItemsSelector('states_rows');
        this.setItemComponentName('address::admin.state.view.item');

        arikaim.ui.loadComponentButton('.state-create');

        search.init({
            id: 'states_rows',
            component: 'address::admin.state.view.rows',
            event: 'state.search.load'
        },'state');
        
        arikaim.events.on('state.search.load',function(result) {   
            arikaim.ui.getComponent('state_paginator').reload();                  
            self.initRows();    
        },'stateSearch');   

        this.initRows();
    };

    this.initRows = function() {    
        $('.status-dropdown').on('change', function() {
            var value = (this).val();
            var uuid = $(this).attr('uuid');
            
            statesControlPanel.setStatus(uuid,value);                        
        });

        arikaim.ui.button('.delete-button',function(element) {
            var uuid = $(element).attr('uuid');
            var title = $(element).attr('data-title');
            var message = arikaim.ui.template.render(statesView.getMessage('remove.content'),{ title: title });

            arikaim.ui.getComponent('confirm_delete').open(function() {
                statesControlPanel.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('#row_' + result.uuid);     
                });
            },message);
        });

        arikaim.ui.button('.edit-button',function(element) {
            var uuid = $(element).attr('uuid');
       
            arikaim.page.loadContent({
                id: 'state_details',
                component: 'address::admin.state.edit',
                params: { uuid: uuid }
            }); 
        });
    }
}

var statesView = createObject(StatesView,ControlPanelView);

arikaim.component.onLoaded(function() {
    statesView.init();   
});