<?php
namespace HBrowser\Service\Form;

use HBrowser\Form\ConfigForm;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class ConfigFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $form = new ConfigForm();
        $globalSettings = $container->get('Omeka\Settings');
        $form->setGlobalSettings($globalSettings);
        return $form;
    }
}