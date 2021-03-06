<?php

namespace MP\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MP\PlatformBundle\Entity\Advert;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * list
 *
 * @ORM\Table(name="list")
 * @ORM\Entity(repositoryClass="MP\PlatformBundle\Repository\listRepository")
 */
class Liste
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
    * @ORM\ManyToMany(targetEntity="MP\PlatformBundle\Entity\Advert", cascade={"persist"})
    */
    private $articles;

    public function __construct()
      {
        $this->articles = new ArrayCollection();
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
    
    public function addArticle(\MP\PlatformBundle\Entity\Advert $article)
    {
        $this->articles[] = $article;

        return $this;    
    }

    /**
     * Remove article
     *
     * @param \MP\PlatformBundle\Entity\Advert $article
     */
    public function removeArticle(\MP\PlatformBundle\Entity\Advert $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
