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

use Arikaim\Core\Controllers\ControlPanelApiController;
use Arikaim\Core\Controllers\Traits\Crud;
use Arikaim\Core\Controllers\Traits\Status;

/** 
 *  City control panel api controller
 */
class CityControlPanel extends ControlPanelApiController
{
    use 
        Crud,
        Status;

    /**
     * Unique columns
     *
     * @var array
     */
    protected $uniqueColumns = [
        'name'       
    ];

    /**
     * Create msg
     *
     * @var string
     */
    protected $createMessage = 'city.add';

    /**
     * Update msg
     *
     * @var string
     */
    protected $updateMessage = 'city.update';

    /**
     * Delete msg
     *
     * @var string
     */
    protected $deleteMessage = 'city.delete';

    /**
     * Default value
     *
     * @var array
     */
    protected $defaultValues = [
        'country_id' => null
    ];

    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('address::admin.messages');   
        $this->setExtensionName('address');
        $this->setModelClass('City');   
    }

    /**
     * Import cities
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param Validator $data
     * @return Psr\Http\Message\ResponseInterface
    */
    public function import($request, $response, $data)
    {
        $countryCode = $data->get('country_code',null);
        $dataSource = $data->get('data_source',null);
        $driver = $this->get('driver')->create('address-api');

        $result = $driver->call('GetCities',['country' => $countryCode]);        
    }
}
