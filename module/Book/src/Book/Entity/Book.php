<?php
namespace Book\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class Book
{
	/**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
	protected $id;

	/** @ORM\Column(type="string") */
	protected $title;

	/**
     * @ORM\OneToMany(targetEntity="Cms\Entity\Page", mappedBy="book")
     */
    private $pages;

    /** @ORM\Column(type="string", unique=true) */
    protected $url;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set title
     *
     * @param string $title
     *
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add page
     *
     * @param \Cms\Entity\Page $page
     *
     * @return Book
     */
    public function addPage(\Cms\Entity\Page $page)
    {
        $this->pages[] = $page;

        return $this;
    }

    /**
     * Remove page
     *
     * @param \Cms\Entity\Page $page
     */
    public function removePage(\Cms\Entity\Page $page)
    {
        $this->pages->removeElement($page);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Book
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
