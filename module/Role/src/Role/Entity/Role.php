<?php
namespace Role\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Role
{
	/**
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    * @ORM\Column(type="integer")
    */
    protected $id;

    /** @ORM\Column(type="string") */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="User\Entity\User", mappedBy="role")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity="Resource\Entity\Resource", inversedBy="roles")
     * @ORM\JoinTable(name="resources_roles")
     */
    private $resources;

    /**
     * @ORM\ManyToMany(targetEntity="Privilege\Entity\Privilege", inversedBy="roles")
     * @ORM\JoinTable(name="roles_privileges",
     *     joinColumns={@ORM\JoinColumn(name="roles_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="privilege_id", referencedColumnName="id")}
     *     )
     */
    protected $privileges;

    /**
     * @ORM\ManyToMany(targetEntity="Role", mappedBy="parents")
     */
    private $children;

    /**
     * @ORM\ManyToMany(targetEntity="Role", inversedBy="children")
     * @ORM\JoinTable(name="roles_parents",
     *      joinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="parent_role_id", referencedColumnName="id")}
     *      )
     */
    private $parents;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
        $this->resources = new \Doctrine\Common\Collections\ArrayCollection();
        $this->privileges = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
        $this->parents = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Role
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
     * Add user
     *
     * @param \User\Entity\User $user
     *
     * @return Role
     */
    public function addUser(\User\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \User\Entity\User $user
     */
    public function removeUser(\User\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add resource
     *
     * @param \Resource\Entity\Resource $resource
     *
     * @return Role
     */
    public function addResource(\Resource\Entity\Resource $resource)
    {
        $this->resources[] = $resource;

        return $this;
    }

    /**
     * Remove resource
     *
     * @param \Resource\Entity\Resource $resource
     */
    public function removeResource(\Resource\Entity\Resource $resource)
    {
        $this->resources->removeElement($resource);
    }

    /**
     * Get resources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Add privilege
     *
     * @param \Privilege\Entity\Privilege $privilege
     *
     * @return Role
     */
    public function addPrivilege(\Privilege\Entity\Privilege $privilege)
    {
        $this->privileges[] = $privilege;

        return $this;
    }

    /**
     * Remove privilege
     *
     * @param \Privilege\Entity\Privilege $privilege
     */
    public function removePrivilege(\Privilege\Entity\Privilege $privilege)
    {
        $this->privileges->removeElement($privilege);
    }

    /**
     * Get privileges
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPrivileges()
    {
        return $this->privileges;
    }

    /**
     * Add child
     *
     * @param \Role\Entity\Role $child
     *
     * @return Role
     */
    public function addChild(\Role\Entity\Role $child)
    {
        $this->children[] = $child;

        return $this;
    }

    /**
     * Remove child
     *
     * @param \Role\Entity\Role $child
     */
    public function removeChild(\Role\Entity\Role $child)
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
     * Add parent
     *
     * @param \Role\Entity\Role $parent
     *
     * @return Role
     */
    public function addParent(\Role\Entity\Role $parent)
    {
        $this->parents[] = $parent;

        return $this;
    }

    /**
     * Remove parent
     *
     * @param \Role\Entity\Role $parent
     */
    public function removeParent(\Role\Entity\Role $parent)
    {
        $this->parents->removeElement($parent);
    }

    /**
     * Get parents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getParents()
    {
        return $this->parents;
    }
}
