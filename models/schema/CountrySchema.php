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
use Arikaim\Core\Utils\Uuid;
use Arikaim\Core\Extension\Extension;

/**
 * Country db table
 */
class CountrySchema extends Schema  
{    
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = 'country';

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
        $table->string('name')->nullable(false);  
        $table->string('currency_code',5)->nullable(true);       
        $table->string('code',5)->nullable(false);         
        $table->string('phone_code')->nullable(true);   
        $table->string('capital')->nullable(true);    
        // index
        $table->unique('code');       
        $table->unique('name');
        $table->index('phone_code');
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

    /**
     * Insert or update rows in table
     *
     * @param Seed $seed
     * @return void
     */
    public function seeds($seed)
    {
        $items = Extension::loadJsonConfigFile('countries.json','address');
       
        $seed->createFromArray(['name'],$items,function($item) {
            $item['uuid'] = Uuid::create();
          
            return $item;
        });
    }
}
