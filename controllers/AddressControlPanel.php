<?php
/**
 * Arikaim
 *
 * @link        http://www.arikaim.com
 * @copyright   Copyright (c) 2016-2018 Konstantin Atanasov <info@arikaim.com>
 * @license     http://www.arikaim.com/license.html
 * 
*/
namespace Arikaim\Extensions\Address\Controllers;

use Arikaim\Core\Controllers\ControlPanelApiController;
use Arikaim\Core\Controllers\Traits\Crud;
use Arikaim\Core\Controllers\Traits\Status;
use Arikaim\Core\Controllers\Traits\SoftDelete;

/** 
 *  Address control panel api controller
 */
class AddressControlPanel extends ControlPanelApiController
{
    use 
        Crud,
        SoftDelete,
        Status;

    /**
     * Create msg
     *
     * @var string
     */
    protected $createMessage = 'address.add';

    /**
     * Update msg
     *
     * @var string
     */
    protected $updateMessage = 'address.update';

    /**
     * Delete msg
     *
     * @var string
     */
    protected $deleteMessage = 'address.delete';

    /**
     * Default field values
     *
     * @var array
     */
    protected $defaultValues = [
        'state_id'   => null,
        'city_id'    => null,
        'country_id' => null
    ];

    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('address::admin.messages');   
        $this->setExtensionName('address');
        $this->setModelClass('Address');

        $this->onBeforeCreate(function($data) {
            $data['user_id'] = $this->getUserId();
           
            return $data;
        });
    }
}
