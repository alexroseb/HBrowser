<?php
namespace HBrowser;

use HBrowser\Form\ConfigForm;
// use HBrowser\Api\Adapter\GetChildren;
use Omeka\Module\AbstractModule;
use Omeka\Entity\Value;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Mvc\Controller\AbstractController;
use Zend\View\Renderer\PhpRenderer;
use Zend\EventManager\Event;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\Mvc\MvcEvent;
use Omeka\Permissions\Acl;
use Omeka\Controller\Site\Item;
use Zend\ServiceManager\ServiceManager;
use Omeka\Entity;

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

    public function getConfigForm(PhpRenderer $renderer) {
        $globalSettings = $this->getServiceLocator()->get('Omeka\Settings');
        $html = '';
        $formElementManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formElementManager->get(ConfigForm::class, []);
        $html .= "<p> Get the below ID(s) from the site database: within the property table, search for the label(s), then put the corresponding ID(s) here. <br/><br/> Current parent IDs: " . $globalSettings->get("hbrowser_parentids") . "</p>";
        $html .= $renderer->formCollection($form, false);

        return $html;
    }

    public function attachListeners(SharedEventManagerInterface $sharedEventManager) {
        $sharedEventManager->attach(
            'Omeka\Controller\Admin\Item',
            'view.show.after',
            [$this, 'handleViewShowAfter']
        ); //delete this after debugging
        $sharedEventManager->attach(
            'Omeka\Controller\Site\Item',
            'view.show.after',
            [$this, 'handleViewShowAfter']
        );
    }

    public function handleViewShowAfter(Event $event) {
        // echo $this->getChildren($site, 37);
        $childrenclass = $this->getServiceLocator();//->get(GetChildren::class);
        // echo $childrenclass->getChildren(37);
        // echo $renderer->partial('hbrowser/hbrowser-sidebar');
    }

    public function addCSS($event)
    {
        $view = $event->getTarget();
        $view->headLink()->appendStylesheet($view->assetUrl('css/hbrowser.css', 'HBrowser'));
    }

//     public function getChildren($site, $id){
//         $sql = <<<ENDSQL
//             SELECT p1.resource_id AS child_id,
//                rtypes.value_resource_id AS child_type,
//                p1.property_id AS child_to_p1,
//                p1.value_resource_id AS parent_id,
//                p2.property_id AS prop2_id,
//                p2.value_resource_id AS parent2_id,
//                p3.property_id AS prop3_id,
//                p3.value_resource_id AS parent3_id,
//                p4.property_id AS prop4_id,
//                p4.value_resource_id AS parent4_id,
//                p5.property_id AS prop5_id,
//                p5.value_resource_id AS parent5_id,
//                p6.property_id AS prop6_id,
//                p6.value_resource_id AS parent6_id,
//                p7.property_id AS prop7_id,
//                p7.value_resource_id AS parent7_id 

//             FROM        value p1 
//             LEFT JOIN   value rtypes ON rtypes.resource_id = p1.resource_id AND rtypes.property_id = 289
//             LEFT JOIN   value p2 ON p2.resource_id = p1.value_resource_id 
//             LEFT JOIN   value p3 ON p3.resource_id = p2.value_resource_id 
//             LEFT JOIN   value p4 ON p4.resource_id = p3.value_resource_id  
//             LEFT JOIN   value p5 ON p5.resource_id = p4.value_resource_id  
//             LEFT JOIN   value p6 ON p6.resource_id = p5.value_resource_id
//             LEFT JOIN   value p7 ON p7.resource_id = p6.value_resource_id

//             WHERE  ?  IN (p1.resource_id,
//                    p1.value_resource_id, 
//                    p2.value_resource_id, 
//                    p3.value_resource_id, 
//                    p4.value_resource_id, 
//                    p5.value_resource_id, 
//                    p6.value_resource_id, 
//                    p7.value_resource_id)

//             AND (p1.property_id IN (?) OR ISNULL(p1.property_id))
//             AND (p2.property_id IN (?) OR ISNULL(p2.property_id))
//             AND (p3.property_id IN (?) OR ISNULL(p3.property_id))
//             AND (p4.property_id IN (?) OR ISNULL(p4.property_id))
//             AND (p5.property_id IN (?) OR ISNULL(p5.property_id))
//             AND (p6.property_id IN (?) OR ISNULL(p6.property_id))
//             AND (p7.property_id IN (?) OR ISNULL(p7.property_id))
// ENDSQL;

//         $serviceLocator = $site->getServiceLocator();
//         $connection = $serviceLocator->get('Omeka\Connection');

//         // $limit = '100';
//         // $bind = array($item->id());
//         $parents = "";
//         $parents = $globalSettings->get("hbrowser_parentids");
//         $result = $connection->fetchAll($sql, $id, $parents, $parents, $parents, $parents, $parents, $parents, $parents);
//         // connection *must* be closed or it will block other queries that this page makes. 
//         $connection->close();
//         return $result;
//     }
}