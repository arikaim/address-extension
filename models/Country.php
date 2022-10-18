<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c) 2016-2018 Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license.html
 * 
*/
namespace Arikaim\Extensions\Address\Models;

use Illuminate\Database\Eloquent\Model;

use Arikaim\Core\Db\Traits\Uuid;
use Arikaim\Core\Db\Traits\Find;
use Arikaim\Core\Db\Traits\Status;

/**
 * Country model
 */
class Country extends Model  
{
    use Uuid,
        Status,       
        Find;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'country';

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [               
        'name',       
        'status',
        'currency_code',
        'code',
        'phone_code',
        'capital'
    ];
    
    /**
     * Disable timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Find country by id, uuid, name or code
     *
     * @param string|int $name
     * @return int|null
     */
    public function findCountryId($name): ?int
    {       
        $model = $this->countryQuery($name)->first();

        return ($model != null) ? $model->id : null;
    }

    /**
     * Country query scope
     *
     * @param Builder $query
     * @param string|int $name
     * @return Builder
     */
    public function scopeCountryQuery($query, $name)
    {
        return $query
            ->where('name','=',$name)
            ->orWhere('code','=',$name)
            ->orWhere('uuid','=',$name)
            ->orWhere('id','=',$name);
    }

    /**
     * Find country
     *
     * @param string $name
     * @return Model|null
     */
    public function findCountry(string $name): ?object
    {
        return $this->countryQuery($name)->first();
    }
}
