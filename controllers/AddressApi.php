<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c) 2016-2018 Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license.html
 * 
*/
namespace Arikaim\Extensions\Address\Controllers;

use Arikaim\Core\Db\Model;
use Arikaim\Core\Controllers\ApiController;

/**
 *  Address api controller
 */
class AddressApi extends ApiController
{
    /**
     * Update map location
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function updateMap($request, $response, $data)
    {
        $uuid = $data->get('uuid',null);
        $latitude = $data->get('latitude',null);
        $longitude = $data->get('longitude',null);

        $address = Model::Address('address')->findById($uuid);
        if ($address == null) {
            $this->error('address.errors','Not vlaid address id');
            return false;
        }

        // check user access
        $this->requireUser($address->user_id);

        $address->update([
            'latitude'  => (empty($latitude) == true) ? null : $latitude,
            'longitude' => (empty($longitude) == true) ? null : $longitude, 
        ]);

        $this
            ->field('uuid',$address->uuid)  
            ->field('latitude',$latitude)  
            ->field('longitude',$longitude)  
            ->message('address.map','Map location saved');   
    }

    /**
     * Update address
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function update($request, $response, $data)
    {
        $uuid = $data->get('uuid',null);
        $countryCode = $data->get('country_code',null);
        $countryId = $data->get('country_id',null);

        $address = Model::Address('address')->findById($uuid);
        if ($address == null) {
            $this->error('address.errors','Not vlaid address id');
            return false;
        }

        // check user access
        $this->requireUser($address->user_id);


        $country = Model::Country('address');
        if (empty($countryCode) == false) {
            $country = $country->findCountry(\strtoupper($countryCode));           
        } else {
            $country = $country->findById($countryId);    
        }

        $data['country_id'] = ($country != null) ? $country->id : null;
        $data['state_id'] = (empty($data['state_id']) == true) ? null : $data['state_id'];

        $address->update($data->toArray());
        
        $this
            ->field('uuid',$address->uuid)  
            ->message('address.update','Address saved');    
    }

    /**
     * Get country list
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function getCountryList($request, $response, $data)
    {
        $this->onDataValid(function($data) {            
            $list = Model::Country('address')->all()->toArray();
           
            $this->setResponse(\is_array($list),function() use($list) {                   
                $this                    
                    ->field('success',true)                
                    ->field('items',$list);  
            },'errors.list');
        });
        $data->validate();

        return $this->getResponse(true); 
    }

    /**
     * Get city list
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function getCityList($request, $response, $data)
    {
        $this->onDataValid(function($data) {          
            $search = $data->get('query','');
            $dataField = $data->get('data_field','uuid');
            $size = $data->get('size',15);
            
            $model = Model::City('address');
            $model = $model->where('name','like','%' . $search . '%')->take($size)->get();
          
            $this->setResponse(\is_object($model),function() use($model,$dataField) {     
                $items = [];
                foreach ($model as $item) {
                    $items[] = ['name' => $item['name'],'value' => $item[$dataField]];
                }
                $this                    
                    ->field('success',true)
                    ->field('results',$items);  
            },'errors.list');
        });
        $data->validate();

        return $this->getResponse(true); 
    }

    /**
     * Get state list
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function getStateList($request, $response, $data)
    {
        $this->onDataValid(function($data) {          
            $countryCode = $data->get('country_code','US');
            $model = Model::State('address');
            $model = $model->where('country_code','=',$countryCode)->get();
                
            $this->setResponse(\is_object($model),function() use($model) {                    
                $this                    
                    ->field('success',true)
                    ->field('items',$model->toArray());  
            },'errors.list');

        });
        $data->validate();

        return $this->getResponse(true); 
    }
}
