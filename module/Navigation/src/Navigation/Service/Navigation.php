<?php
namespace Navigation\Service;

use Interop\Container\ContainerInterface;
use Zend\Navigation\Service\DefaultNavigationFactory;

class Navigation extends DefaultNavigationFactory
{
    protected function getPages(ContainerInterface $serviceLocator)
    {
        $em = $serviceLocator->get('Doctrine\ORM\EntityManager');
        $repository = $em->getRepository('Navigation\Entity\Navigation');
        $authenticationService = $serviceLocator->get('Zend\Authentication\AuthenticationService');
        $items = array();

        $role = 'Guest';
        if ($authenticationService->getIdentity()) {
            $role = $authenticationService->getIdentity()->getRole()->getName();
        }

        if (null === $this->pages) {
            $navigations = $repository->findBy(array(),array('name'=>'ASC'));
            foreach ($navigations as $navigation) {
                foreach ($navigation->getRoles() as $roles) {
                    if ($roles->getName() == $role) {
                        $items[] = array(
                            'label' => $navigation->getName(),
                            'route' => $navigation->getRoute(),
                            'resource' => $navigation->getResource()->getName(),
                            'privilege' => $navigation->getPrivilege()->getName(),
                            'visible' => (($navigation->getStatus()) ? true : false),
                            'order' => $navigation->getOrder(),
                        );
                    }
                }
            }

            $mvcEvent = $serviceLocator->get('Application')
                      ->getMvcEvent();

            $routeMatch = $mvcEvent->getRouteMatch();
            $router     = $mvcEvent->getRouter();
            $pages      = $this->getPagesFromConfig($items);

            $this->pages = $this->injectComponents(
                $pages,
                $routeMatch,
                $router
            );
        }

        return $this->pages;
    }
}