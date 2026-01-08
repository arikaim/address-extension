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
 * States model
 */
class State extends Model  
{
    use Uuid,
        Status,       
        Find;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'states';

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [               
        'name',       
        'status',
        'country_id',
        'country_code',
        'code'       
    ];
    
    /**
     * Disable timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Find state Id
     *
     * @param string $name
     * @return integer|null
     */
    public function findStateId(string $name): ?int
    {
        $model = $this->findByColumn($name,['uuid','name','code']);

        return ($model != null) ? $model->id : null;
    }

    /**
     * Find state
     *
     * @param string $code
     * @param string|null $countryCode
     * @return Model|null
     */
    public function findState(string $code, ?string $countryCode = null): ?object
    {
        $query = $this->where('code','=',$code);
        if (empty($countryCode) == false) {
            $query->where('country_code','=',$countryCode);
        }

        return $query->first();
    }

    /**
     * Scope query by country code
     *
     * @param Builder $query
     * @param string|null $countryCode
     * @return Builder
     */
    public function scopeCountryQuery($query, ?string $countryCode)
    {
        return (empty($countryCode) == true) ? $query : $query->where('country_code','=',$countryCode);
    }

    /**
     * Country relation
     *
     * @return Relation|null
     */
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
}
