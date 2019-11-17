<?php
namespace HBrowser\Form;

use Zend\Form\Form;

class ConfigForm extends Form
{
    protected $globalSettings;
    public function init()
    {
        $this->add([
            'type' => 'checkbox',
            'name' => 'hbrowser_item',
            'options' => [
                        'label' => 'Woohoo!', // @translate
                    ],
            'attributes' => [
                'checked' => $this->globalSettings->get('hbrowser_setting') ? 'checked' : '',
                'id' => 'hbrowser-setting',
            ],
        ]);
    }
    public function setGlobalSettings($globalSettings)
    {
        $this->globalSettings = $globalSettings;
    }
}