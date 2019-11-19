<?php
namespace HBrowser\Service\Form;

use HBrowser\Form\ConfigForm;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ConfigFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new ConfigForm($container->get('Omeka\Settings'));
        // $globalSettings = ;
        // $form->setGlobalSettings($globalSettings);
        return $form;
    }
}