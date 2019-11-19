<?php
namespace HBrowser\Form;

use Zend\Form\Form;

class ConfigForm extends Form
{
    protected $globalSettings;

    public function init() {
        $this->add([
            'name' => 'hbrowser_parentids',
            'options' => [
                        'label' => 'Parent Property ID(s), separated by commas',
                    ],
            'attributes' => [
                // 'value' => $placeholder,
            ],
        ]);
    }

    public function setGlobalSettings($globalSettings) {
        $this->globalSettings = $globalSettings;
    }
}