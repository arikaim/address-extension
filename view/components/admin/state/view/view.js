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

        search.init({
            id: 'states_rows',
            component: 'address::admin.state.view.rows',
            event: 'state.search.load'
        },'state');
        
        arikaim.events.on('state.search.load',function(result) {                
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
            var message = arikaim.ui.template.render(self.getMessage('remove.content'),{ title: title });

            modal.confirmDelete({ 
                title: self.getMessage('remove.title'),
                description: message
            },function() {
                statesControlPanel.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('#row_' + result.uuid);     
                });
            });
        });

        arikaim.ui.button('.edit-button',function(element) {
            var uuid = $(element).attr('uuid');
       

            arikaim.page.loadContent({
                id: 'states_content',
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