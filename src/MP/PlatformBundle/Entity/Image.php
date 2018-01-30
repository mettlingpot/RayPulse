<?php

namespace MP\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Image
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="MP\PlatformBundle\Repository\ImageRepository")
 */
class Image
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
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;
    /**
    * @Assert\File(
    *     maxSize = "2000k",
    *     mimeTypesMessage = "taille max 2Mo"
    * )
    */
    private $file;

    private $tempFilename;

    /**
    * @ORM\PrePersist()
    * @ORM\PreUpdate()
    */
    public function preUpload()
    {
      if (null === $this->file) {
        return;
      }
      $this->url = $this->file->guessExtension();
      $this->alt = $this->file->getClientOriginalName();
    }
    /**
    * @ORM\PostPersist()
    * @ORM\PostUpdate()
    */
    public function upload()
    {
    // Si jamais il n'y a pas de fichier (champ facultatif), on ne fait rien
    if (null === $this->file) {
      return;
    }

    if (null !== $this->tempFilename) {
      $oldFile = $this->getUploadRootDir().'/'.$this->id.'.'.$this->tempFilename;
      if (file_exists($oldFile)) {
        unlink($oldFile);
      }
    }
    $this->file->move(
      $this->getUploadRootDir(),
      $this->id.'.'.$this->url   
    );
  }

  /**
   * @ORM\PreRemove()
   */
  public function preRemoveUpload()
  {
    $this->tempFilename = $this->getUploadRootDir().'/'.$this->id.'.'.$this->url;
  }

  /**
   * @ORM\PostRemove()
   */
  public function removeUpload()
  {
    if (file_exists($this->tempFilename)) {
      unlink($this->tempFilename);
    }
  }

  public function getUploadDir()
  {
    return 'uploads/img';
  }

  protected function getUploadRootDir()
  {
    return __DIR__.'/../../../../web/'.$this->getUploadDir();
  }
    
    public function getFile()
      {
        return $this->file;
      }

    /**
    * @param UploadedFile $file
    */
    public function setFile(UploadedFile $file)
    {
      $this->file = $file;
      // On vérifie si on avait déjà un fichier pour cette entité
      if (null !== $this->url) {
        // On sauvegarde l'extension du fichier pour le supprimer plus tard
        $this->tempFilename = $this->url;
        // On réinitialise les valeurs des attributs url et alt
        $this->url = null;
        $this->alt = null;
      }
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
     * Set url
     *
     * @param string $url
     *
     * @return Image
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

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return Image
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }
      
    public function getWebPath()
    {
      return $this->getUploadDir().'/'.$this->getId().'.'.$this->getUrl();
    }

}
