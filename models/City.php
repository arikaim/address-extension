<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c) 2016-2018 Intersoft Ltd <info@arikaim.com>
 * @license     http://www.arikaim.com/license.html
 * 
*/
namespace Arikaim\Extensions\Address\Models;

use Illuminate\Database\Eloquent\Model;

use Arikaim\Extensions\Address\Models\Country;
use Arikaim\Extensions\Address\Models\State;
use Arikaim\Core\Db\Traits\Uuid;
use Arikaim\Core\Db\Traits\Find;
use Arikaim\Core\Db\Traits\Status;
use Arikaim\Core\Db\Traits\UserRelation;
use Arikaim\Core\Db\Traits\OptionsAttribute;

/**
 * City model
 */
class City extends Model  
{
    use Uuid,
        Status,    
        UserRelation,
        OptionsAttribute,
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
        'state_id',
        'options',
        'post_code',
        'phone_code',
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
     * @return object|null
     */
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }

    /**
     * State relation
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class,'state_id');
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
       $query->ignoreCase('name',$name,'=');
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
        return ($this->findCity($name,$userId) != null);       
    } 

    /**
     * Find city by name and user
     * 
     * @param string $name
     * @param mixed $userId
     */
    public function findCity(string $name, ?int $userId = null): ?object
    {
        return $this->cityQuery($name,$userId)->first();
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
