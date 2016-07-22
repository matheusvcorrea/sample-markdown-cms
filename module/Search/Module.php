<?php
namespace Search;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Search\View\Helper\Search;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                // a chave do array aqui é o nome pelo qual você
                // chamará o seu view helper no script da view
                'searchForm' => function($sm) {
                    $serviceManager = $sm->getServiceLocator();
                    $mvcEvent = $serviceManager->get('Application')->getMvcEvent();
                    return new Search($mvcEvent);
                },
            ),
        );
    }
}