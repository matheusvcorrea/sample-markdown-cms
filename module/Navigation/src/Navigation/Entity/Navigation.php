<?php
namespace Navigation\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Navigation
{
	/**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
	protected $id;

	/** @ORM\Column(type="string") */
	protected $name;

    /** @ORM\Column(type="string") */
    protected $route;

    /** @ORM\Column(type="smallint") */
    protected $order;

    /**
     * @ORM\ManyToOne(targetEntity="Resource\Entity\Resource")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id")
     */
    private $resource;

    /**
     * @ORM\ManyToOne(targetEntity="Privilege\Entity\Privilege")
     * @ORM\JoinColumn(name="privilege_id", referencedColumnName="id")
     */
    private $privilege;

	/**
     * @ORM\OneToMany(targetEntity="Navigation", mappedBy="parent")
     */
    private $children;

    /**
     * @ORM\ManyToOne(targetEntity="Navigation", inversedBy="children")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id")
     */
    private $parent;

    /** @ORM\Column(type="boolean") */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity="Role\Entity\Role")
     * @ORM\JoinTable(name="navigations_roles",
     *      joinColumns={@ORM\JoinColumn(name="navigation_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     *      )
     */
    private $roles;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Navigation
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return Navigation
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set order
     *
     * @param integer $order
     *
     * @return Navigation
     */
    public function setOrder($order)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return integer
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Navigation
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set resource
     *
     * @param \Resource\Entity\Resource $resource
     *
     * @return Navigation
     */
    public function setResource(\Resource\Entity\Resource $resource = null)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return \Resource\Entity\Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set privilege
     *
     * @param \Privilege\Entity\Privilege $privilege
     *
     * @return Navigation
     */
    public function setPrivilege(\Privilege\Entity\Privilege $privilege = null)
    {
        $this->privilege = $privilege;

        return $this;
    }

    /**
     * Get privilege
     *
     * @return \Privilege\Entity\Privilege
     */
    public function getPrivilege()
    {
        return $this->privilege;
    }

    /**
     * Add child
     *
     * @param \Navigation\Entity\Navigation $child
     *
     * @return Navigation
     */
    public function addChild(\Navigation\Entity\Navigation $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Navigation\Entity\Navigation $child
     */
    public function removeChild(\Navigation\Entity\Navigation $child)
    {
        $this->children->removeElement($child);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Navigation\Entity\Navigation $parent
     *
     * @return Navigation
     */
    public function setParent(\Navigation\Entity\Navigation $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Navigation\Entity\Navigation
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add role
     *
     * @param \Role\Entity\Role $role
     *
     * @return Navigation
     */
    public function addRole(\Role\Entity\Role $role)
    {
        $this->roles[] = $role;

        return $this;
    }

    /**
     * Remove role
     *
     * @param \Role\Entity\Role $role
     */
    public function removeRole(\Role\Entity\Role $role)
    {
        $this->roles->removeElement($role);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
