<?php

return [
	'view_manager' => [
        'template_path_stack' => [
            OMEKA_PATH.'/modules/HBrowser/view',
        ],
    ],
    'form_elements' => [
        'factories' => [
            'HBrowser\Form\ConfigForm' => 'HBrowser\Service\Form\ConfigFormFactory',
        ],
    ],

];