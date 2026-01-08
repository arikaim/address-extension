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
use Arikaim\Core\Controllers\Traits\ApiPaginator;

/**
 *  City api controller
 */
class CityApi extends ApiController
{
    use ApiPaginator;

    /**
     * Get cities list
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function getCities($request, $response, $data)
    {
        $countryCode = $data->get('country',null);
        $page = $data->get('page',1);
        $perPage = $data->get('perPage',25);
        $userId = $this->getUserId();
        $country = null;
        if (empty($countryCode) == false && (\is_numeric($countryCode) == false)) {
            $country = Model::Country('address')->findCountry(\strtoupper($countryCode));
            if (\is_object($country) == false) {
                return $this
                    ->error('errors.country')
                    ->getResponse();                            
            }
        }
      
        $page = (\is_numeric($countryCode) == true) ? $countryCode : $page;
        $countryId = (\is_object($country) == true) ? $country->id : null;

        $model = Model::City('address')->countryQuery($countryId);
        $this->paginate($model,$page,$perPage);
   
        $this->setResponse(\is_object($model),function() use($countryCode,$request,$userId) { 
            $this                                   
                ->field('country',$countryCode);              
        },'errors.list');      

        return $this->getResponse(); 
    }

    /**
     * Add city
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function add($request, $response, $data)
    {
        $countryCode = $data->get('country_code',null);
        $countryId = $data->get('country_id',null);
        $country = Model::Country('address');
        $city = Model::City('address');

        if ($this->hasControlPanelAccess() == false) {
            return $this
                ->error('errors.access')
                ->getResponse();  
        }

        if (empty($countryCode) == false) {
            $country = $country->findCountry(\strtoupper($countryCode));           
        } else {
            $country = $country->findById($countryId);    
        }

        if (\is_object($country) == false) {
            return $this
                ->error('errors.country')
                ->getResponse();                            
        }
        $data['country_id'] = $country->id;
        
        if ($city->hasCity($data['name']) == true) {
            return $this
                ->error('errors.exist')
                ->getResponse();  
        }

        $created = $city->create($data->toArray());
        
        $this->setResponse(\is_object($created),function() use($created) {     
            $this                                   
                ->field('uuid',$created->uuid);              
        },'errors.create');  

        return $this->getResponse(); 
    }
}
