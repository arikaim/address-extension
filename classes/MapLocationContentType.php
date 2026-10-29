<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Intersoft Ltd <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Address\Classes;

use Arikaim\Core\Content\Type\ContentType;

/**
 * Map location content type class
*/
class MapLocationContentType extends ContentType 
{
    /**
     * Define map location type
     *
     * @return void
     */
    protected function define(): void
    {
        $this->setName('map.location');
        $this->setTitle('Map Location');
        // fields
        $this->addField('latitude','number','Latitude');
        $this->addField('longitude','number','Longitude');      
    }
}
