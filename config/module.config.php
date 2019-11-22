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
        	'hBrowserSidebar' => Site\BlockLayout\HBrowserSidebar::class,
        ],
    ],
    'api_adapters' => [
        'invokables' => [
            'getChildren' => Api\Adapter\GetChildren::class,
        ],
    ],

];