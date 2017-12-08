<?php

namespace MP\MairieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MP\MairieBundle\Entity\Article;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * list
 *
 * @ORM\Table(name="liste")
 * @ORM\Entity(repositoryClass="MP\MairieBundle\Repository\listRepository")
 */
class liste
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
    * @ORM\ManyToMany(targetEntity="MP\MairieBundle\Entity\Article", cascade={"persist"})
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
    
    public function addArticle(\MP\MairieBundle\Entity\Article $article)
    {
        $this->articles[] = $article;

        return $this;    
    }
}

