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
use Arikaim\Core\Extension\Extension;
use Arikaim\Core\Utils\Uuid;
use Arikaim\Core\Db\Model;

/**
 * States db table
 */
class States extends Schema  
{    
    /**
     * Table name
     *
     * @var string
     */
    protected $tableName = 'states';

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
        $table->string('code',10)->nullable(false);  
        $table->string('country_code',10)->nullable(false);  
        $table->relation('country_id','country',true); 
       
        $table->index('country_code');      
        $table->unique(['code','country_code']);      
        $table->unique('name');
    }

    /**
     * Update table
     *
     * @param \Arikaim\Core\Db\TableBlueprint $table
     * @return void
     */
    public function update($table) 
    {   
        if ($this->hasIndex('states_code_unique') == true) {
            $table->dropUnique('states_code_unique');
            $table->unique(['code','country_code']);        
        }           
    }

    /**
     * Insert or update rows in table
     *
     * @param Seed $seed
     * @return void
     */
    public function seeds($seed)
    {
        $items = Extension::loadJsonConfigFile('states.json','address');
        $country = Model::Country('address');

        $seed->createFromArray(['name'],$items,function($item) use($country) {
            $item['uuid'] = Uuid::create();
            $item['country_id'] = $country->findCountryId($item['country_code']);
            
            return $item;
        });
    }
}
