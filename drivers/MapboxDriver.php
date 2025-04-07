<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Address\Drivers;

use Arikaim\Core\Driver\Traits\Driver;
use Arikaim\Core\Interfaces\Driver\DriverInterface;

/**
 * Mapbox maps driver class
 */
class MapboxDriver implements DriverInterface
{   
    use Driver;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->setDriverParams('mapbox.map','map','Mapbox','Driver for Mapbox maps service.');      
    }

    /**
     * Initialize driver
     *
     * @return void
     */
    public function initDriver($properties)
    {             
    }

    /**
     * Create driver config properties array
     *
     * @param Arikaim\Core\Collection\Properties $properties
     * @return void
     */
    public function createDriverConfig($properties)
    {
        $properties->property('public_token',function($property) {
            $property
                ->title('Public Access Token')
                ->type('text')
                ->default('')
                ->required(true);
        });  
        $properties->property('private_token',function($property) {
            $property
                ->title('Private Access Token')
                ->type('text')
                ->default('')
                ->required(false);
        });      
    }
}
