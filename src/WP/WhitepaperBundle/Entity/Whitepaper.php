<?php

namespace WP\WhitepaperBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Whitepaper
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="WP\WhitepaperBundle\Entity\WhitepaperRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Whitepaper
{
    /**
     * @ORM\ManyToOne(targetEntity="WP\UserBundle\Entity\User")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="WP\WhitepaperBundle\Entity\File", cascade={"remove","persist"})
     * @ORM\JoinColumn(nullable=true) // Force l’ajout d’une image pour chaque Advert
     */
    private $file;

    /**
     * @ORM\OneToOne(targetEntity="WP\WhitepaperBundle\Entity\Image", cascade={"remove","persist"})
     * @ORM\JoinColumn(nullable=true) // Force l’ajout d’une image pour chaque Advert
     */
    private $image;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\Length(min=10)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="lang", type="string", length=10, nullable=true)
     */
    private $lang;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="published_on", type="date")
     */
    private $publishedOn;

    /**
     * @ORM\Column(name="published", type="boolean")
     */
    private $published = false;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    public function __construct() {
        $this->publishedOn = new \Datetime();
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
     * @return Whitepaper
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
     * Set description
     *
     * @param string $description
     * @return Whitepaper
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set publishedOn
     *
     * @param \DateTime $publishedOn
     * @return Whitepaper
     */
    public function setPublishedOn($publishedOn)
    {
        $this->publishedOn = $publishedOn;

        return $this;
    }

    /**
     * Get publishedOn
     *
     * @return \DateTime 
     */
    public function getPublishedOn()
    {
        return $this->publishedOn;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Whitepaper
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set published
     *
     * @param boolean $published
     * @return Whitepaper
     */
    public function setPublished($published)
    {
        $this->published = $published;

        return $this;
    }

    /**
     * Get published
     *
     * @return boolean 
     */
    public function getPublished()
    {
        return $this->published;
    }

    /**
     * @ORM\PreUpdate
     */
    public function updateDate()
    {
        $this->setUpdatedAt(new \Datetime());
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Whitepaper
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set lang
     *
     * @param string $lang
     * @return Whitepaper
     */
    public function setLang($lang)
    {
        $this->lang = $lang;

        return $this;
    }

    /**
     * Get lang
     *
     * @return string 
     */
    public function getLang()
    {
        return $this->lang;
    }

    /**
     * Set file
     *
     * @param \WP\WhitepaperBundle\Entity\File $file
     * @return Whitepaper
     */
    public function setFile(\WP\WhitepaperBundle\Entity\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \WP\WhitepaperBundle\Entity\File 
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set user
     *
     * @param \WP\UserBundle\Entity\User $user
     * @return Whitepaper
     */
    public function setUser(\WP\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \WP\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set image
     *
     * @param \WP\WhitepaperBundle\Entity\Image $image
     * @return Whitepaper
     */
    public function setImage(\WP\WhitepaperBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \WP\WhitepaperBundle\Entity\Image 
     */
    public function getImage()
    {
        return $this->image;
    }
}
