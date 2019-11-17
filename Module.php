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

    public function getConfig() {
        return include __DIR__.'/config/module.config.php';
    }

    public function handleConfigForm(AbstractController $controller) {
        $params = $controller->params()->fromPost();
        if (isset($params['propertyIds'])) {
            $propertyIds = $params['propertyIds'];
        } else {
            $propertyIds = [];
        }
        $globalSettings = $this->getServiceLocator()->get('Omeka\Settings');
        $globalSettings->set('hbrowser_setting', $params['hbrowser_setting']);
    }

    public function getConfigForm(PhpRenderer $renderer)
    {
        $globalSettings = $this->getServiceLocator()->get('Omeka\Settings');
        $escape = $renderer->plugin('escapeHtml');
        $translator = $this->getServiceLocator()->get('MvcTranslator');
        $html = '';
        // $html .= "<script type='text/javascript'>
        // var filteredPropertyIds = $filteredPropertyIds;
        // </script>
        // ";
        $formElementManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formElementManager->get(ConfigForm::class, []);
        $html .= "<p>" . $translator->translate("This is a form?") . "</p>";
        $html .= $renderer->formCollection($form, false);

        return $html;
    }

    // public function addCSS($event)
    // {
    //     $view = $event->getTarget();
    //     $view->headLink()->appendStylesheet($view->assetUrl('css/hbrowser.css', 'HBrowser'));
    // }