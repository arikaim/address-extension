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
use Arikaim\Extensions\Address\Models\City;
use Arikaim\Extensions\Address\Models\State;

use Arikaim\Core\Content\Traits\ContentProvider;
use Arikaim\Core\Db\Traits\Uuid;
use Arikaim\Core\Db\Traits\UserRelation;
use Arikaim\Core\Db\Traits\Find;
use Arikaim\Core\Db\Traits\DateCreated;
use Arikaim\Core\Db\Traits\DateUpdated;
use Arikaim\Core\Db\Traits\SoftDelete;
use Arikaim\Core\Db\Traits\Status;

use Arikaim\Core\Interfaces\Content\ContentProviderInterface;

/**
 * Address model
 */
class Address extends Model implements ContentProviderInterface
{
    // address type constant
    const TYPE_HOME     = 'home';
    const TYPE_BUSINESS = 'business';
    const TYPE_BILLING  = 'billing';
    const TYPE_SHIPPING = 'shipping';

    use 
        ContentProvider,
        Uuid,
        Status,
        UserRelation,
        DateCreated,
        DateUpdated,
        SoftDelete,
        Find;

    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'address';

    /**
     * Fillable attributes
     *
     * @var array
     */
    protected $fillable = [               
        'user_id',     
        'first_name',
        'last_name',
        'type',
        'city_id', 
        'country_id', 
        'state_id', 
        'custom_state', 
        'custom_country', 
        'custom_city', 
        'zip_code', 
        'address', 
        'address_2', 
        'latitude', 
        'longitude', 
        'phone', 
        'email', 
        'website',
        'date_created',
        'date_deleted',
        'date_updated'
    ];
    
    /**
     * Disable timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Content provider content types
     *
     * @var array
     */
    protected $supportedContentTypes = ['address'];

    /**
     * Provider name
     *
     * @var string
     */
    protected $contentProviderName = 'address';
    
    /**
     * Content provider title
     *
     * @var string
     */
    protected $contentProviderTitle = 'Address';

    /**
     * Return true if address has map location
     *
     * @return boolean
     */
    public function hasMapLocation(): bool
    {
        return ( (empty($this->latitude) == false) && (empty($this->longitude) == false) );
    }

    /**
     * Get total data items
     *
     * @return integer|null
     */
    public function getItemsCount(): ?int
    {
        return $this->all()->count();
    }

    /**
     * Get content
     *
     * @param string|int|array $key  Id, Uuid or content name slug
     * @param string|null $contentType  Content type name
     * @param string|array|null $keyFields
     * @return array|null
     */
    public function getContent($key, ?string $contentType = null, $keyFields = null): ?array
    {
        $model = $this->findById($key);
        if ($model == null) {
            return null;
        }
        $data = $model->toArray();
        $data['city'] = $model->city_name;
        $data['state'] = $model->state_name;
        $data['country'] = $model->country_name;

        return $data;
    }

    /**
     * Get country_name attribute
     *
     * @return string|null
     */
    public function getCountryNameAttribute()
    {
        if (empty($this->custom_country) == false) {
            return $this->custom_country;
        }

        return (empty($this->country_id) == false) ? $this->country->name : null;
    }

    /**
     * Get city_name attribute
     *
     * @return string|null
     */
    public function getCityNameAttribute()
    {
        return (empty($this->custom_city) == true) ? $this->city->name : $this->custom_city;
    }

    /**
     * Get state_name attribute
     *
     * @return string|null
     */
    public function getStateNameAttribute()
    {
        return (empty($this->custom_state) == true) ? $this->state->name : $this->custom_state;
    }

    /**
     * Get country relation
     *
     * @return Relation|null
     */
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id')->withDefault(function ($city) {
            $country = new Country();
            $country->name = $this->custom_country;            
            return $country;
        });
    }

    /**
     * Get city relation
     *
     * @return Relation|null
     */
    public function city()
    {
        return $this->belongsTo(City::class,'city_id')->withDefault(function ($city) {
            $city = new City();
            $city->name = $this->custom_city;
            return $city;
        });
    }

    /**
     * Get state relation
     *
     * @return Relation|null
     */
    public function state()
    {
        return $this->belongsTo(State::class,'state_id')->withDefault(function ($state) {
            $state = new State();
            $state->name = $this->custom_state;            
            return $state;
        });
    }

    /**
     * Create empty
     *
     * @param integer|null $userId
     * @return Model|null
     */
    public function createEmpty(?int $userId)
    {
        return $this->create(['user_id' => $userId]);
    }

    /**
     * Create new content item
     *
     * @param array $data
     * @param string|null $contentType  Content type name
     * @return array|null
     */
    public function createItem(array $data, ?string $contentType = null): ?array
    {
        $data = $this->resolveData($data);
        $model = $this->create($data);
        if (\is_object($model) == false) {
            return null;
        }

        return [$model->uuid,$this->getProviderName()];
    }

    /**
     * Save content item
     *
     * @param string|int $key
     * @param array $data
     * @param string|null $contentType  Content type name
     * @return boolean
     */
    public function saveItem($key, array $data, ?string $contentType = null): bool
    {
        $model = $this->findById($key);
        if ($model == null) {
            return false;
        }
        $data = $this->resolveData($data);
        
        return (bool)$model->update($data);            
    }

    /**
     * Format addaress data array
     *
     * @param array $data
     * @return array
     */
    private function resolveData($data): array
    {
        $data['city_id'] = (empty($data['city_id']) == true) ? null : $data['city_id'];
        $data['country_id'] = (empty($data['country_id']) == true) ? null : $data['country_id'];
        $data['state_id'] = (empty($data['state_id']) == true) ? null : $data['state_id'];

        return $data;
    }
}
