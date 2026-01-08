<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Address\Classes;

use Arikaim\Core\Content\Type\Action;
use Arikaim\Core\Db\Model;

/**
 * Address import form paypal checkout transaction data
 */
class ImportFromPayPalCheckout extends Action
{
    /**
     * Init action
     *
     * @return void
     */
    public function init(): void
    {
        $this->setName('address.import.paypal');
        $this->setType('import');
        $this->setTitle('Import address from paypal transaction data.');
    }

    /**
     * Execute action
     *
     * @param mixed $content    
     * @param array|null $options
     * @return mixed
     */
    public function execute($content, ?array $options = []) 
    {
        $data['first_name'] = $content['FIRSTNAME'] ?? null;
        $data['last_name'] = $content['LASTNAME'] ?? null;
        
        $country = $content['COUNTRYCODE'] ?? null;
        $city = $content['SHIPTOCITY'] ?? null;
        $state = $content['SHIPTOSTATE'] ?? null;

        $data['address'] = $content['SHIPTOSTREET'] ?? null;
        $data['address_2'] = null;
        $data['zip_code'] = $content['SHIPTOZIP'] ?? null;
        $data['phone'] = null;
        $data['email'] = $content['EMAIL'] ?? null;

        if (empty($country) == false) {
            $data['country_id'] = Model::Country('address')->findCountryId($country);      
            $data['custom_country'] = (empty($data['country_id']) == true) ? $country : null;       
        }
        if (empty($city) == false) {
            $data['city_id'] = Model::City('address')->findCityId($city);    
            $data['custom_city'] = (empty($data['city_id']) == true) ? $city : null;         
        }
        if (empty($state) == false) {
            $data['state_id'] = Model::State('address')->findStateId($state); 
            $data['custom_state'] = (empty($data['state_id']) == true) ? $state : null;               
        }

        $model = Model::Address('address')->create($data);

        return $model;
    }
}
