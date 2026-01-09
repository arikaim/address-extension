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
        
        this.setItemsSelector('country_rows');
        this.setItemComponentName('address::admin.country.view.item');

        arikaim.ui.loadComponentButton('.country-create');

        search.init({
            id: 'country_rows',
            component: 'address::admin.country.view.rows',
            event: 'country.search.load'
        },'country');
        
        arikaim.events.on('country.search.load',function(result) { 
            arikaim.ui.getComponent('country_paginator').reload();     
            self.initRows();    
        },'countrySearch');   

        this.initRows();
    };

    this.initRows = function() {    
        $('.status-dropdown').on('change', function() {
            var value = $(this).val();
            var uuid = $(this).attr('uuid');

            countryControlPanel.setStatus(uuid,value);               
        });

        arikaim.ui.button('.delete-country-button',function(element) {
            var uuid = $(element).attr('uuid');
            var title = $(element).attr('data-title');
            var message = arikaim.ui.template.render(countryView.getMessage('delete.content'),{ title: title });
            
            arikaim.ui.getComponent('confirm_delete').open(function() {
                countryControlPanel.delete(uuid,function(result) {
                    arikaim.ui.table.removeRow('#row_' + result.uuid);     
                });
            },message);
        });

        arikaim.ui.button('.edit-country-button',function(element) {
            var uuid = $(element).attr('uuid');
            
            arikaim.page.loadContent({
                id: 'country_details',
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