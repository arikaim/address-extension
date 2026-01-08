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

use Arikaim\Extensions\Address\Models\Country;
use Arikaim\Core\Db\Traits\Uuid;
use Arikaim\Core\Db\Traits\Find;
use Arikaim\Core\Db\Traits\Status;

/**
 * City model
 */
class City extends Model  
{
    use Uuid,
        Status,       
        Find;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'city';

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [               
        'name',       
        'uuid',
        'status',
        'user_id',
        'country_id',
        'is_capital',
        'map_latitude',
        'map_longitude'
    ];
    
    /**
     * Disable timestamps
     *
     * @var boolean
     */
    public $timestamps = false;    

    /**
     * Country relation
     *
     * @return Relation|null
     */
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    /**
     * Country scope query
     *
     * @param Builder $query
     * @param string|null $countryId
     * @return Builder
     */
    public function scopeCountryQuery($query, ?string $countryId)
    {
        return (empty($countryId) == false) ? $query->where('country_id','=',$countryId) : $query;
    }

    /**
     * Find city query
     *
     * @param Builder $query
     * @param string $name
     * @param integer|null $userId
     * @return Builder
     */
    public function scopeCityQuery($query, string $name, ?int $userId = null)
    {
       $query->where('name','=',$name);
       if (empty($userId) == false) {
           $query->where('user_id','=',$userId);
       }

       return $query;
    }

    /**
     * Return true if city exist
     *
     * @param string $name
     * @param integer|null $userId
     * @return boolean
     */
    public function hasCity(string $name, ?int $userId = null): bool
    {
        return ($this->cityQuery($name,$userId)->first() != null);       
    } 

    /**
     * Find city Id
     *
     * @param string $name
     * @return integer|null
     */
    public function findCityId(string $name): ?int
    {
        $model = $this->findByColumn($name,['uuid','name']);

        return ($model != null) ? $model->id : null;
    }
}
