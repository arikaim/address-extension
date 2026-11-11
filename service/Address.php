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

    /**
     * Find address
     * @param mixed $country
     * @param mixed $city
     * @param string|null $street
     */
    public function findAddress($country, $city, ?string $street): ?object
    {
        // country
        $countryModel = Model::Country('address')->findCountry($country);
        if ($countryModel == null) {
            return null;
        }

        // city
        $cityModel = Model::City('address')->findCity($city);
        if ($cityModel == null) {
            return null;
        }

        $address = Model::Address('address')
            ->findAddress($countryModel->id, $cityModel->id, $street)
            ->first();

        return $address;
    }

    /**
     * Fidn or create address
     * @param mixed $country
     * @param string $cityName
     * @param mixed $street
     * @param array $data
     * @param mixed $userId
     * @return array|object|null
     */
    public function findOrCreateAddress(
        $country,
        string $cityName,
        ?string $street,
        array $data,
        ?int $userId = null
    ): ?object {
        $address = $this->findAddress($country, $cityName, $street);
        if ($address == null) {
            $data['address'] = $street;
            return $this->createAddress($country, $cityName, $data, $userId);
        }

        return $address;
    }

    /**
     * Create address
     * @param mixed $country
     * @param string $cityName
     * @param array $data
     * @param mixed $userId
     */
    public function createAddress(
        $country,
        string $cityName,
        array $data,
        ?int $userId = null
    ): ?array {
        $data['user_id'] = $userId ?? $data['user_id'] ?? null;
        $data = $this->resolveAddressData($country, $cityName, $data);

        return Model::Address('address')->createItem($data);
    }

    protected function resolveAddressData($country, string $cityName, array $data): array
    {
        $data['user_id'] = $userId ?? $data['user_id'] ?? null;

        $countryModel = Model::Country('address')->findCountry($country);
        $data['country_id'] = ($countryModel == null) ? null : $countryModel->id;

        $city = $this->createOrUpdateCity(
            $countryModel->code,
            $cityName,
            $data['city'] ?? [],
            $data['user_id']
        );

        $data['city_id'] = ($city != null) ? $city->id : null;

        return $data;
    }

    /**
     * Create or update city
     * @param mixed $country
     * @param string $name
     * @param array $data
     * @param mixed $userId
     */
    public function createOrUpdateCity(
        $country,
        string $name,
        array $data,
        ?int $userId = null
    ): ?object {
        $data['user_id'] = $userId ?? $data['user_id'] ?? null;
        $data['name'] = $name;

        $countryModel = Model::Country('address')->findCountry($country);
        if ($countryModel == null) {
            return null;
        }
        $data['country_id'] = $countryModel->id;

        $model = Model::City('address');
        $city = $model->findCity($name, $data['user_id']);

        if ($city == null) {
            return $model->create($data);
            ;
        }

        $city->update($data);

        return $city;
    }
}
