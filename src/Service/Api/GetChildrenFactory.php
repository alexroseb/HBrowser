<?php
namespace HBrowser\Service\Api;

use HBrowser\Api\Adapter\GetChildren;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class GetChildrenFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $gettingchildren = new GetChildren();
        return $gettingchildren;
    }
}