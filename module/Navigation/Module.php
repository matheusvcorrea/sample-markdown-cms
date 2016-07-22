<?php
namespace Navigation;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager = $e->getApplication()->getEventManager();
        $this->serviceManager = $e->getApplication()->getServiceManager();
        $moduleRouteListener = new ModuleRouteListener();
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
                // Acl Navigation
	            'navigation' => function($sm) {
	            	$aclService = $sm->getServiceLocator()->get('AclService');
	            	$authenticationService = $sm->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

	            	$role = 'Guest';
			        if ($authenticationService->getIdentity()) {
			            $role = $authenticationService->getIdentity()->getRole()->getName();
			        }

	            	$navigation = $sm->get('Zend\View\Helper\Navigation');
	            	$navigation->setAcl($aclService->getAcl())->setRole($role);

	                return $navigation;
	            }
	        )
	    );
	}
}