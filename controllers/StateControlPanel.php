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
use Arikaim\Core\Db\Model;

/** 
 *  State control panel api controller
 */
class StateControlPanel extends ControlPanelApiController
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
    protected $createMessage = 'state.add';

    /**
     * Update msg
     *
     * @var string
     */
    protected $updateMessage = 'state.update';

    /**
     * Delete msg
     *
     * @var string
     */
    protected $deleteMessage = 'state.delete';

    /**
     * Init controller
     *
     * @return void
     */
    public function init()
    {
        $this->loadMessages('address::admin.messages');
        $this->setExtensionName('address');
        $this->setModelClass('State');

        $beforeSave = function($data) {
            if (empty($data['country_code'] ?? '') == true) {
                $country = Model::Country('address');
                $model = $country->findById($data['country_id']);
                $data['country_code'] = \strtoupper($model->code);
            }
          
            return $data;
        };

        $this->onBeforeCreate($beforeSave);
        $this->onBeforeUpdate($beforeSave);
    }
}
