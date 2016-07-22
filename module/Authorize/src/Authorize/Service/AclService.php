<?php
namespace Authorize\Service;

use Doctrine\ORM\EntityManager;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\AclInterface;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;
use Zend\ServiceManager\ServiceLocatorInterface;

class AclService implements AclInterface
{
	/**
	 * @var Acl
	 */
	protected $acl;

	/**
	 * @var Role
	 */
	protected $role;

	/**
	 * @var Resource
	 */
	protected $resource;

	/**
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * @var EntityManager
     */
    protected $em;

	/**
	 * Constructor
	 *
	 * @param ServiceLocatorInterface
	 */
	public function __construct(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		// Prepare
		$this->addRoles();
		$this->addResources();
		
		$this->allow();
	}

	/**
     * Retrieve serviceManager instance
     *
     * @return ServiceLocatorInterface
     */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}

	/**
     * Sets the EntityManager
     *
     * @param EntityManager $em
     * @access protected
     * @return AbstractActionController
     */
    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

	/**
     * Returns the EntityManager
     *
     * Fetches the EntityManager from ServiceLocator if it has not been initiated
     * and then returns it
     *
     * @access protected
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        
        return $this->em;
    }

	/**
	 * Set Acl instance
	 * 
	 * @param Acl $acl
	 * @return Acl
	 */
	public function setAcl(Acl $acl)
	{
		return $this->acl = $acl;
	}
	
	/**
	 * Retrieve Acl instance
	 * 
	 * @return Acl
	 */
	public function getAcl()
	{
		if (!$this->acl) {
			$this->setAcl(new Acl());
		}

		return $this->acl;
	}

	/**
	 * Add groups to the Role
	 *
	 * @return void
	 */
	public function addRoles()
	{
		$provider = $this->getServiceLocator()->get('RoleProvider');
		$em       = $this->getEntityManager()->getRepository($provider);
		
		foreach ($em->findAll() as $role) {
			$parents = array();
			foreach ($role->getParents() as $parent) {
				$parents[] = $parent->getName();
			}

			if (!$this->hasRole($role->getName())) {
				$this->getAcl()->addRole(new Role($role->getName()), $parents);
			}
		}
	}

	/**
	 * Add groups to the Resource
	 *
	 * @return void
	 */
	public function addResources()
	{
		$provider = $this->getServiceLocator()->get('ResourceProvider');
		$em       = $this->getEntityManager()->getRepository($provider);

		foreach ($em->findAll() as $resource) {
			if (!$this->hasResource($resource->getName())) {
				$this->getAcl()->addResource(new Resource($resource->getName()));
			}
		}
	}

	/**
	 * Define allow access
	 * 
	 * @return void
	 */
	public function allow()
	{
		$provider = $this->getServiceLocator()->get('RoleProvider');
		$em       = $this->getEntityManager()->getRepository($provider);
		
		foreach ($em->findAll() as $role) {
			$resources = array();
			foreach ($role->getResources() as $resource) {
				$resources[] = $resource->getName();
			}

			$privileges = array();
			foreach ($role->getPrivileges() as $privilege) {
				$privileges[] = $privilege->getName();
			}

			$this->getAcl()->allow($role->getName(), (empty($resources) ? null : $resources), $privileges);
		}
	}

	/**
     * Returns true if and only if the Role exists in the registry
     *
     * The $role parameter can either be a Role or a Role identifier.
     *
     * @param  string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->getAcl()->hasRole($role);
    }

	/**
     * Returns true if and only if the Resource exists in the ACL
     *
     * The $resource parameter can either be a Resource or a Resource identifier.
     *
     * @param  string $resource
     * @return bool
     */
	public function hasResource($resource)
	{
		return $this->getAcl()->hasResource($resource);
	}

	/**
	 * Returns true if and only if the Role has access to the Resource
	 * 
	 * @param  Role|string      $role  
	 * @param  Resource|string  $resource  
	 * @param  string           $privilege 
	 * @return boolean
	 */
	public function isAllowed($role = null, $resource = null, $privilege = null)
	{
		$acl = $this->getAcl();

		try {
			return $acl->isAllowed($role, $resource, $privilege);
		} catch (\Exception $e) {
			echo 'Acl: ' . $e->getMessage();
		}
	}
}