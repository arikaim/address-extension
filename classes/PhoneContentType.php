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

use Arikaim\Core\Content\Type\ContentType;

/**
 * Phone content type class
*/
class PhoneContentType  extends ContentType 
{
    /**
     * Define map location type
     *
     * @return void
     */
    protected function define(): void
    {
        $this->setName('phone');
        $this->setTitle('Phone');
        // fields
        $this->addField('phone','number','Phone');
        $this->addField('country_code','number','Country Code');  
        $this->addField('type','text','Type');      
    }
}
