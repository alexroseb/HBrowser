<?php
namespace HBrowser;

use HBrowser\Form\ConfigForm;
use Omeka\Module\AbstractModule;
use Omeka\Entity\Value;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\AbstractController;
use Zend\View\Renderer\PhpRenderer;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Mvc\MvcEvent;
use Omeka\Permissions\Acl;

class Module extends AbstractModule {

    public function handleConfigForm(AbstractController $controller) {
        $params = $controller->params()->fromPost();
        if (isset($params['hbrowser_parentids'])) {
            $parentIds = $params['hbrowser_parentids'];
        } else {
            $parentIds = "";
        }
        $globalSettings = $this->getServiceLocator()->get('Omeka\Settings');
        $globalSettings->set('hbrowser_parentids', $parentIds);
    }

    public function getConfigForm(PhpRenderer $renderer)
    {
        $globalSettings = $this->getServiceLocator()->get('Omeka\Settings');
        $html = '';

        $html .= $globalSettings->get("hbrowser_parentids");

        $formElementManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formElementManager->get(ConfigForm::class, []);
        $html .= "<p> Get the below ID(s) from the site database: within the property table, search for the label(s), then put the corresponding ID(s) here.</p>";
        $html .= $renderer->formCollection($form, false);

        return $html;
    }

    public function addCSS($event)
    {
        $view = $event->getTarget();
        $view->headLink()->appendStylesheet($view->assetUrl('css/hbrowser.css', 'HBrowser'));
    }
}