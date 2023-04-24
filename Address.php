<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Address;

use Arikaim\Core\Extension\Extension;
use Arikaim\Core\Db\Model;

/**
 * Address extension
*/
class Address extends Extension
{
    /**
     * Install extension routes, events, jobs ..
     *
     * @return void
    */
    public function install()
    {                   
        // Control Panel
        // country
        $this->addApiRoute('POST','/api/admin/address/country/add','CountryControlPanel','create','session');   
        $this->addApiRoute('PUT','/api/admin/address/country/update','CountryControlPanel','update','session');       
        $this->addApiRoute('DELETE','/api/admin/address/country/delete/{uuid}','CountryControlPanel','delete','session');     
        $this->addApiRoute('PUT','/api/admin/address/country/status','CountryControlPanel','setStatus','session');          
        // address
        $this->addApiRoute('POST','/api/admin/address/add','AddressControlPanel','create','session');   
        $this->addApiRoute('PUT','/api/admin/address/update','AddressControlPanel','update','session');       
        $this->addApiRoute('DELETE','/api/admin/address/delete/{uuid}','AddressControlPanel','softDelete','session');     
        $this->addApiRoute('PUT','/api/admin/address/status','AddressControlPanel','setStatus','session'); 
        // city
        $this->addApiRoute('POST','/api/admin/address/city/add','CityControlPanel','create','session');   
        $this->addApiRoute('PUT','/api/admin/address/city/update','CityControlPanel','update','session');       
        $this->addApiRoute('DELETE','/api/admin/address/city/delete/{uuid}','CityControlPanel','delete','session');     
        $this->addApiRoute('PUT','/api/admin/address/city/status','CityControlPanel','setStatus','session'); 
        // states
        $this->addApiRoute('POST','/api/admin/address/state/add','StateControlPanel','create','session');   
        $this->addApiRoute('PUT','/api/admin/address/state/update','StateControlPanel','update','session');       
        $this->addApiRoute('DELETE','/api/admin/address/state/delete/{uuid}','StateControlPanel','delete','session');     
        $this->addApiRoute('PUT','/api/admin/address/state/status','StateControlPanel','setStatus','session'); 
        // Api 
        $this->addApiRoute('PUT','/api/address/update','AddressApi','update','session');    
        $this->addApiRoute('GET','/api/address/country/list','AddressApi','getCountryList','session');
        $this->addApiRoute('GET','/api/address/city/list/{data_field}/[{query}]','AddressApi','getCityList','session');
        $this->addApiRoute('GET','/api/address/state/list/[{country_code}]','AddressApi','getStateList','session');
        // city api 
        $this->addApiRoute('GET','/api/address/cities[/{country}[/{page:\d+}[/{perPage:\d+}]]]','CityApi','getCities',['session','token']);
        $this->addApiRoute('POST','/api/address/city','CityApi','add',['session','token']);

        // Create db tables      
        $this->createDbTable('CountrySchema');
        $this->createDbTable('CitySchema');
        $this->createDbTable('StatesSchema');
        $this->createDbTable('AddressSchema');
    
        // Relation map 
        $this->addRelationMap('address','Address');
        // Content Types
        $this->registerContentType('Classes\\AddressContentType');
        $this->registerContentType('Classes\\MapLocationContentType');
        $this->registerContentType('Classes\\PhoneContentType');
        // Content type actions
        $this->registerContentTypeAction('address','Classes\\ExportToVCardAction');
        $this->registerContentTypeAction('address','Classes\\ImportFromArray');        
        $this->registerContentTypeAction('address','Classes\\ImportFromStripeCheckout');  
        $this->registerContentTypeAction('address','Classes\\ImportFromPayPalCheckout');  
        // Content providers
        $this->registerContentProvider(Model::Address('address'));
        // Drivers
        $this->installDriver('Arikaim\\Extensions\\Address\\Drivers\\GoogleMapsDriver');
        $this->installDriver('Arikaim\\Extensions\\Address\\Drivers\\MapboxDriver');
        // Current map driver
        $this->createOption('map.default.driver','mapbox.map');    
    } 
}
