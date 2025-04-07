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

/** 
 *  Country control panel api controller
 */
class CountryControlPanel extends ControlPanelApiController
{
    use 
        Crud,
        Status;

    /**
     * Unique columns
     *
     * @var array
     */
    protected $uniqueColumns = [
        'name',
        'code'
    ];

    /**
     * Create msg
     *
     * @var string
     */
    protected $createMessage = 'country.add';

    /**
     * Update msg
     *
     * @var string
     */
    protected $updateMessage = 'country.update';

    /**
     * Delete msg
     *
     * @var string
     */
    protected $deleteMessage = 'country.delete';

    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('address::admin.messages');
        $this->setExtensionName('address');
        $this->setModelClass('Country');

        $beforeSave = function($data) {
            $data['code'] = \strtoupper($data['code']);
           
            return $data;
        };

        $this->onBeforeCreate($beforeSave);
        $this->onBeforeUpdate($beforeSave);
    }
}
