<?php

namespace HBrowser;

return [
	'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    'block_layouts' => [
        'invokables' => [
        	'hBrowserSidebar' => Site\BlockLayout\HBrowserSidebar::class,
        ],
    ],

];