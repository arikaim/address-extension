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
use Arikaim\Core\Db\Model;
use Arikaim\Core\Extension\Extension;
use Arikaim\Core\Utils\Uuid;

/**
 * City db table
 */
class City extends Schema  
{    
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = 'city';

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
        $table->userId();               
        $table->relation('country_id','country',true); 
        $table->string('name')->nullable(false);  
        $table->integer('is_capital')->nullable(true);         
        $table->string('map_latitude')->nullable(true);   
        $table->string('map_longitude')->nullable(true);   

        $table->unique(['name','user_id']);
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
        $items = Extension::loadJsonConfigFile('city.json','address');
        $country = Model::Country('address');
      
        $seed->createFromArray(['name'],$items,function($item) use($country) {
            $item['uuid'] = Uuid::create();
            $item['country_id'] = $country->findCountryId($item['country']);
            $item['is_capital'] = 1;
                   
            unset($item['country']);

            return $item;
        });       
    }
}
