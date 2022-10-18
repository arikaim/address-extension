/**
 *  Arikaim
 *  @copyright  Copyright (c)  <info@arikaim.com>
 *  @license    http://www.arikaim.com/license
 *  http://www.arikaim.com
*/
'use strict';

function CountryView() {
    var self = this;

    this.init = function() {
        this.loadMessages('address::admin.country');
        
        paginator.init('country_rows');

        search.init({
            id: 'country_rows',
            component: 'address::admin.country.view.rows',
            event: 'country.search.load'
        },'country');
        
        arikaim.events.on('country.search.load',function(result) {      
            paginator.reload();
            self.initRows();    
        },'countrySearch');   
    };

    this.initRows = function() {    
        $('.status-dropdown').dropdown({
            onChange: function(value) {
                var uuid = $(this).attr('uuid');
                countryControlPanel.setStatus(uuid,value);               
            }
        });

        arikaim.ui.button('.delete-country-button',function(element) {
            var uuid = $(element).attr('uuid');
            var title = $(element).attr('data-title');

            var message = arikaim.ui.template.render(self.getMessage('delete.content'),{ title: title });
            modal.confirmDelete({ 
                title: self.getMessage('delete.title'),
                description: message
            },function() {
                countryControlPanel.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('#row_' + result.uuid);     
                });
            });
        });

        arikaim.ui.button('.edit-country-button',function(element) {
            var uuid = $(element).attr('uuid');
            arikaim.ui.setActiveTab('#country_edit','.country-tab-item');

            arikaim.page.loadContent({
                id: 'country_content',
                component: 'address::admin.country.edit',
                params: { uuid: uuid }
            }); 
        });
    }
}

var countryView = createObject(CountryView,ControlPanelView);

arikaim.component.onLoaded(function() {
    countryView.init();   
});