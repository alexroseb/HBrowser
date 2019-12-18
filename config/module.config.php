<?php

namespace HBrowser;

return [
	'view_manager' => [
        'template_path_stack' => [
            OMEKA_PATH.'/modules/HBrowser/view',
        ],
    ],
    'block_layouts' => [
        'invokables' => [
        	'hBrowserSidebar' => 'HBrowser\Site\BlockLayout\HBrowserSidebar::class',
        ],
    ],
    'api_adapters' => [
        'invokables' => [
            'getChildren' => 'HBrowser\Api\Adapter\GetChildren::class',
        ],
        'factories' => [
            'HBrowser\Api\Adapter\GetChildren' => 'HBrowser\Service\Api\GetChildrenFactory',
        ],
    ],

];