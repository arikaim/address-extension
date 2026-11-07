<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Intersoft Ltd <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Address\Service;

use Arikaim\Core\Service\Service;
use Arikaim\Core\Service\ServiceInterface;

use Arikaim\Core\Db\Model;

/**
 * Address service class
*/
class Address extends Service implements ServiceInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setServiceName('address');
    }    

    public function createAddress(
        string $countryCode, 
        string $cityName, 
        array $data, 
        ?int $userId = null
    ): ?array
    {
        $data['user_id'] = $userId ?? $data['user_id'] ?? null;
        $data = $this->resolveAddressData($countryCode, $cityName, $data);

        return Model::Country('address')->createItem($data); 
    }

    protected function resolveAddressData(string $countryCode, string $cityName, array $data): array
    {
        $data['user_id'] = $userId ?? $data['user_id'] ?? null;

        $country = Model::Country('address')->findByCode($countryCode);
        $data['country_id'] = ($country == null) ? null : $country->id;

        $city = $this->createOrUpdateCity(
            $countryCode,
            $cityName,
            $data['city'] ?? [],
            $data['user_id']
        );

        $data['city_id'] = ($city != null) ? $city->id : null;
       
        return $data;
    }

    /**
     * Create or update city
     * @param string $countryCode
     * @param string $name
     * @param array $data
     * @param mixed $userId
     */
    public function createOrUpdateCity(
        string $countryCode, 
        string $name, 
        array $data, 
        ?int $userId = null
    ): ?object
    {  
        $data['user_id'] = $userId ?? $data['user_id'] ?? null;
        $data['name'] = $name;
      
        $country = Model::Country('address')->findByCode($countryCode);
        if ($country == null) {
            return null;
        }
        $data['country_id'] = $country->id;
        
        $model = Model::City('address');
        $city = $model->findCity($name,$data['user_id']);

        if ($city == null) {
            return $model->create($data);;
        }

        $city->update($data);

        return $city;
    }
}
