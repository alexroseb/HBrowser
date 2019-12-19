<?php
namespace HBrowser\Controller;

use Omeka\Api\Manager as ApiManager;
use Omeka\Mvc\Exception;
use Omeka\Stdlib\Paginator;
use Omeka\View\Model\ApiJsonModel;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\Mvc\MvcEvent;
use Zend\Stdlib\RequestInterface as Request;

class HBrowserApiController extends AbstractRestfulController
{    
    /**
     * @var ApiManager
     */
    protected $api;

    public function __construct(ApiManager $api)
    {
        $this->api = $api;
    }

    public function getChildren($id)
    {
        $response = "Alex Test text";
        return new ApiJsonModel($response);
    }
}