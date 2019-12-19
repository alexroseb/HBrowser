<?php
namespace HBrowser\Service\Controller;
use Interop\Container\ContainerInterface;
use HBrowser\Controller\HBrowserApiController;
use Zend\ServiceManager\Factory\FactoryInterface;
class HBrowserApiControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $services, $requestedName, array $options = null)
    {
        return new HBrowserApiController(
            $services->get('Omeka\ApiManager')
        );
    }
}