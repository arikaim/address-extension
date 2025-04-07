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
 * Address content type class
*/
class AddressContentType extends ContentType 
{
    /**
     * Define address type
     *
     * @return void
     */
    protected function define(): void
    {
        $this->setName('address');
        $this->setTitle('Address');
        // fields
        $this->addField('first_name','text','First Name');
        $this->addField('last_name','text','Last Name');       
        $this->addField('city','text','City');
        $this->addField('country','text','Country');
        $this->addField('state','text','State');
        $this->addField('zip_code','number','Zip Code');
        $this->addField('address','text','Address');
        $this->addField('address_2','text','Address 2');
        $this->addField('email','email','Email');
        $this->addField('phone','number','Phone');
        $this->addField('website','url','Website');
        $this->addField('type','text','Type');

        // searchable fields
        $this->setSearchableFields([
            'first_name',
            'last_name',
            'zip_code',
            'phone',
            'email'
        ]);

        $this->setTitleFields([
            'first_name',       
            'email'
        ]);
    }
}
