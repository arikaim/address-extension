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
 * Address import form stripe checkout transaction data
 */
class ImportFromStripeCheckout extends Action
{
    /**
     * Init action
     *
     * @return void
     */
    public function init(): void
    {
        $this->setName('address.import.stripe');
        $this->setType('import');
        $this->setTitle('Import address from stripe transaction data.');
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
        $stripeAddress = $content['customer_details']['address'] ?? [];
        $name = \trim($content['customer_details']['name'] ?? '');
        $nameParts = \explode(' ',$name);
        $data['first_name'] = $nameParts[0] ?? null;
        $data['last_name'] = $nameParts[1] ?? null;
        
        $country = $stripeAddress['country'] ?? null;
        $city = $stripeAddress['city'] ?? null;
        $state = $stripeAddress['state'] ?? null;

        $data['address'] = $stripeAddress['line1'] ?? null;
        $data['address_2'] = $stripeAddress['line2'] ?? null;
        $data['zip_code'] = $stripeAddress['postal_code'] ?? null;
        $data['phone'] = $content['customer_details']['phone'] ?? null;
        $data['email'] = $content['customer_details']['email'] ?? null;

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
