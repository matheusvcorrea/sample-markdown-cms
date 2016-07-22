<?php
namespace Authorize;

use Authorize\Event\AuthenticateEvent;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\ModuleEvent;
use Zend\ModuleManager\ModuleManager;

class Module
{
    public function init(ModuleManager $moduleManager)
    {
        $events = $moduleManager->getEventManager();

        // Registering a listener at default priority, 1, which will trigger
        // after the ConfigListener merges config.
        $events->attach(ModuleEvent::EVENT_MERGE_CONFIG, array($this, 'onMergeConfig'));
    }

    /**
     * Callback to EVENT_MERGE_CONFIG to register new listener in the global application
     * 
     * @param  ModuleEvent $e
     * @return void
     */
    public function onMergeConfig(ModuleEvent $e)
    {
        $configListener = $e->getConfigListener();
        $config = $configListener->getMergedConfig(false);

        // Modify the configuration; here, we'll remove a specific key:
        if (!isset($config['AuthorizeRouteListener'])) {
            $config[] = ['AuthorizeRouteListener'];
        }
        else if (!isset($config['AuthenticateListener'])) {
            $config[] = ['AuthenticateListener'];
        }


        // Pass the changed configuration back to the listener:
        $configListener->setMergedConfig($config);
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                },

                'AclService' => function($serviceManager) {
                    return new \Authorize\Service\AclService($serviceManager);
                }
            )
        );
    }
    
	public function onBootstrap(MvcEvent $e)
    {
        $eventManager   = $e->getApplication()->getEventManager();
        $serviceManager = $e->getApplication()->getServiceManager();
        
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attachAggregate($serviceManager->get('AuthorizeRouteListener'));
        $eventManager->attachAggregate($serviceManager->get('AuthenticateListener'));
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
}