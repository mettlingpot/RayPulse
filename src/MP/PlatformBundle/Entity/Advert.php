<?php

namespace MP\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MP\UserBundle\Entity\User;
use MP\PlatformBundle\Entity\Adresse;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Advert
 *
 * @ORM\Table(name="advert")
 * @ORM\Entity(repositoryClass="MP\PlatformBundle\Repository\AdvertRepository")
 */
class Advert
{
    /**
   * @ORM\ManyToOne(targetEntity="MP\UserBundle\Entity\User")
   */
    private $user;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedebut", type="datetime")
     */
    private $datedebut;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datefin", type="datetime")
     */
    private $datefin;
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;
    /**
     * @var string
     *
     * @ORM\Column(name="site", type="string", length=255, nullable=true)
     */
    private $site;
    /**
     * @var string
     *
     * @ORM\Column(name="prix", type="string", length=25, nullable=true)
     */
    private $prix;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;
    
    /**
    * @ORM\Column(name="published", type="boolean")
    */
    private $published = true;

    
    /**
    * @ORM\OneToOne(targetEntity="MP\PlatformBundle\Entity\Image", cascade={"persist","remove"})
    * @Assert\Valid
    */
    private $image;
    
    /**
    * @ORM\ManyToMany(targetEntity="MP\PlatformBundle\Entity\Category", cascade={"persist"})
    */
    private $categories;
    /**
    * @ORM\OneToOne(targetEntity="MP\PlatformBundle\Entity\Adresse", cascade={"persist"})
    */
    private $adresse;

    public function __construct()
      {
        $this->datedebut = new \Datetime();
        $this->datefin = new \Datetime();
        $this->categories = new ArrayCollection();
        $this->adresse = new Adresse();
      }
    
    /**
     * Get id
     *
     * @return int
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
     * @return Advert
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
     * Set author
     *
     * @param string $author
     *
     * @return Advert
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Advert
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set published
     *
     * @param boolean $published
     *
     * @return Advert
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
     * Set image
     *
     * @param \MP\PlatformBundle\Entity\Image $image
     *
     * @return Advert
     */
    public function setImage(\MP\PlatformBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \MP\PlatformBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Add category
     *
     * @param \MP\PlatformBundle\Entity\Category $category
     *
     * @return Advert
     */
    public function addCategory(\MP\PlatformBundle\Entity\Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * Remove category
     *
     * @param \MP\PlatformBundle\Entity\Category $category
     */
    public function removeCategory(\MP\PlatformBundle\Entity\Category $category)
    {
        $this->categories->removeElement($category);
    }

    /**
     * Get categories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set datedebut
     *
     * @param \DateTime $datedebut
     *
     * @return Advert
     */
    public function setDatedebut($datedebut)
    {
        $this->datedebut = $datedebut;

        return $this;
    }

    /**
     * Get datedebut
     *
     * @return \DateTime
     */
    public function getDatedebut()
    {
        return $this->datedebut;
    }

    /**
     * Set datefin
     *
     * @param \DateTime $datefin
     *
     * @return Advert
     */
    public function setDatefin($datefin)
    {
        $this->datefin = $datefin;

        return $this;
    }

    /**
     * Get datefin
     *
     * @return \DateTime
     */
    public function getDatefin()
    {
        return $this->datefin;
    }

    /**
     * Set site
     *
     * @param string $site
     *
     * @return Advert
     */
    public function setSite($site)
    {
        $this->site = $site;

        return $this;
    }

    /**
     * Get site
     *
     * @return string
     */
    public function getSite()
    {
        return $this->site;
    }

    /**
     * Set prix
     *
     * @param string $prix
     *
     * @return Advert
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
    }

 

    /**
     * Set user
     *
     * @param \MP\UserBundle\Entity\User $user
     *
     * @return Advert
     */
    public function setUser(\MP\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \MP\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add adresse
     *
     * @param \MP\PlatformBundle\Entity\Adresse $adresse
     *
     * @return Advert
     */
    public function addAdresse(\MP\PlatformBundle\Entity\Adresse $adresse)
    {
        $this->adresse[] = $adresse;

        return $this;
    }

    /**
     * Remove adresse
     *
     * @param \MP\PlatformBundle\Entity\Adresse $adresse
     */
    public function removeAdresse(\MP\PlatformBundle\Entity\Adresse $adresse)
    {
        $this->adresse->removeElement($adresse);
    }

    /**
     * Get adresse
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAdresse()
    {
        return $this->adresse;
    }
}
