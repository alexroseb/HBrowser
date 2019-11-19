<?php
	namespace HBrowser\Site\BlockLayout;

	use Omeka\Api\Exception\NotFoundException;
	use Omeka\Api\Representation\SiteRepresentation;
	use Omeka\Api\Representation\SitePageRepresentation;
	use Omeka\Api\Representation\SitePageBlockRepresentation;
	use Omeka\Entity\SitePageBlock;
	use Omeka\Module\Manager as ModuleManager;
	use Omeka\Site\BlockLayout\AbstractBlockLayout;
	use Zend\View\Renderer\PhpRenderer;

	class HBrowserSidebar extends AbstractBlockLayout {

	    public function getLabel(){
	        return 'Hierarchical Browser'; 
	    }
		public function render(PhpRenderer $view, SitePageBlockRepresentation $block) {
        	return $view->partial('hbrowser/hbrowser-sidebar', [
        
        	]);
    	}
    	public function form(PhpRenderer $view, SiteRepresentation $site, SitePageRepresentation $page = null, SitePageBlockRepresentation $block = null ) {
		    // $textarea = new Textarea("o:block[__blockIndex__][o:data][html]");
		    // $textarea->setAttribute('class', 'block-html full wysiwyg');
		    // if ($block) {
		    //     $textarea->setAttribute('value', $block->dataValue('html'));
		    // }
		    // return $view->formRow($textarea);
		}
	}