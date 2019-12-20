<?php
namespace HBrowser\Service;
use HBrowser\Api\HBManager;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;
class HBApiManagerFactory implements FactoryInterface
{
    /**
     * Create the CLI service.
     *
     * @return Cli
     */
    public function __invoke(ContainerInterface $serviceLocator, $requestedName, array $options = null)
    {
        $adapterManager = $serviceLocator->get('Omeka\ApiAdapterManager');
        $acl = $serviceLocator->get('Omeka\Acl');
        $logger = $serviceLocator->get('Omeka\Logger');
        $translator = $serviceLocator->get('MvcTranslator');
        return new HBManager($adapterManager, $acl, $logger, $translator);
    }
}