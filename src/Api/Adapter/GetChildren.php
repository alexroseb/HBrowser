<?php
namespace HBrowser\Api;

use Omeka\Api\Request;
use Zend\ServiceManager\ServiceManager;

class GetChildren extends AbstractEntityAdapter{

  public function getChildren($id){
    echo "getChildren";
        $sql = <<<ENDSQL
            SELECT p1.resource_id AS child_id,
               rtypes.value_resource_id AS child_type,
               p1.property_id AS child_to_p1,
               p1.value_resource_id AS parent_id,
               p2.property_id AS prop2_id,
               p2.value_resource_id AS parent2_id,
               p3.property_id AS prop3_id,
               p3.value_resource_id AS parent3_id,
               p4.property_id AS prop4_id,
               p4.value_resource_id AS parent4_id,
               p5.property_id AS prop5_id,
               p5.value_resource_id AS parent5_id,
               p6.property_id AS prop6_id,
               p6.value_resource_id AS parent6_id,
               p7.property_id AS prop7_id,
               p7.value_resource_id AS parent7_id 

            FROM        value p1 
            LEFT JOIN   value rtypes ON rtypes.resource_id = p1.resource_id AND rtypes.property_id = 289
            LEFT JOIN   value p2 ON p2.resource_id = p1.value_resource_id 
            LEFT JOIN   value p3 ON p3.resource_id = p2.value_resource_id 
            LEFT JOIN   value p4 ON p4.resource_id = p3.value_resource_id  
            LEFT JOIN   value p5 ON p5.resource_id = p4.value_resource_id  
            LEFT JOIN   value p6 ON p6.resource_id = p5.value_resource_id
            LEFT JOIN   value p7 ON p7.resource_id = p6.value_resource_id

            WHERE  ?  IN (p1.resource_id,
                   p1.value_resource_id, 
                   p2.value_resource_id, 
                   p3.value_resource_id, 
                   p4.value_resource_id, 
                   p5.value_resource_id, 
                   p6.value_resource_id, 
                   p7.value_resource_id)

            AND (p1.property_id IN (?) OR ISNULL(p1.property_id))
            AND (p2.property_id IN (?) OR ISNULL(p2.property_id))
            AND (p3.property_id IN (?) OR ISNULL(p3.property_id))
            AND (p4.property_id IN (?) OR ISNULL(p4.property_id))
            AND (p5.property_id IN (?) OR ISNULL(p5.property_id))
            AND (p6.property_id IN (?) OR ISNULL(p6.property_id))
            AND (p7.property_id IN (?) OR ISNULL(p7.property_id))
ENDSQL;

        $serviceLocator = $site->getServiceLocator();
        $connection = $serviceLocator->get('Omeka\Connection');

        // $limit = '100';
        // $bind = array($item->id());
        $parents = "";
        $globalSettings = $serviceLocator->get('Omeka\Settings');
        $parents = $globalSettings->get("hbrowser_parentids");
        $result = $connection->fetchAll($sql, $id, $parents, $parents, $parents, $parents, $parents, $parents, $parents);
        // connection *must* be closed or it will block other queries that this page makes. 
        $connection->close();
        return $result;
    }
}