<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Address\Service;

use Arikaim\Core\Service\Service;
use Arikaim\Core\Service\ServiceInterface;

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
}
