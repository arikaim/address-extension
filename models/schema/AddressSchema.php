<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c) 2016-2018 Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license.html
 * 
*/
namespace Arikaim\Extensions\Address\Models\Schema;

use Arikaim\Core\Db\Schema;

/**
 * Address db table
 */
class AddressSchema extends Schema  
{    
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = 'address';

    /**
     * Create table
     *
     * @param \Arikaim\Core\Db\TableBlueprint $table
     * @return void
     */
    public function create($table) 
    {            
        // columns    
        $table->id();      
        $table->prototype('uuid'); 
        $table->status();           
        $table->string('type',50)->nullable(true);   
        $table->relation('city_id','city',true); 
        $table->relation('country_id','country',true); 
        $table->relation('state_id','states',true); 
        $table->string('first_name')->nullable(true);        
        $table->string('last_name')->nullable(true);  
        $table->string('custom_state')->nullable(true);  
        $table->string('custom_country')->nullable(true);  
        $table->string('custom_city')->nullable(true);  
        $table->string('zip_code')->nullable(true);        
        $table->string('address')->nullable(true);   
        $table->string('address_2')->nullable(true);   
        $table->decimal('latitude',12,8)->nullable(true);   
        $table->decimal('longitude',12,8)->nullable(true);   
        $table->string('email')->nullable(true);  
        $table->string('phone')->nullable(true);  
        $table->string('website')->nullable(true);          
        $table->userId();
        
        $table->dateCreated();
        $table->dateUpdated();
        $table->dateDeleted();
    }

    /**
     * Update table
     *
     * @param \Arikaim\Core\Db\TableBlueprint $table
     * @return void
     */
    public function update($table) 
    {              
    }
}
