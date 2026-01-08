<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c)  Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license
 * 
*/
namespace Arikaim\Extensions\Address\Models\Traits;

use Arikaim\Extensions\Address\Models\Address;

/**
 * Address relation trait
 *      
*/
trait AddressRelation 
{    
    /**
     * Get address relation
     *
     * @return Relation|null
     */
    public function address()
    {
        return $this->belongsTo(Address::class,'address_id')->withDefault(function ($address) {
            $userId = empty($this->user_id) ? null : $this->user_id;
            $address = $address->createEmpty($userId);
            $this->address_id = $address->id;  
            $this->save();
            
            return $address;
        });
    }

    /**
     * Return true if address relation exist
     *
     * @return boolean
     */
    public function hasAddress(): bool
    {
        return (empty($this->address_id) == true) ? false : ($this->address->first() !== null);
    }

    /**
     * Return  tru eif address is empty
     *
     * @return boolean
     */
    public function isEmptyAddress(): bool
    {
        return $this->address->isEmpty();
    }
}
