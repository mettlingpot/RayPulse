<?php

namespace MP\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use MP\PlatformBundle\Entity\Advert;
use Doctrine\Common\Collections\ArrayCollection;
use MP\PlatformBundle\Entity\Adresse;
use JMS\Serializer\Annotation as Serializer;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="MP\UserBundle\Repository\UserRepository")
 *
 * @Serializer\ExclusionPolicy("ALL")
 */
class User implements UserInterface
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
     * @ORM\Column(name="username", type="string", length=255, unique=true)
     *
     * @Serializer\Expose
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    private $salt = '';

    /**
     * @var array
     *
     * @ORM\Column(name="roles", type="array")
     */
    private $role = ['ROLE_AUTEUR'];
    /**
    * @ORM\OneToOne(targetEntity="MP\PlatformBundle\Entity\Adresse", cascade={"persist"})
    */
    private $adresse;
    /**
    * @ORM\ManyToMany(targetEntity="MP\PlatformBundle\Entity\Advert", cascade={"persist"})
    */
    private $favoris;
    /**
     * Constructor
     */
    public function __construct()
      {
        $this->favoris = new ArrayCollection();
        $this->adresse = new Adresse();
      }

    public function eraseCredentials()
    {
        
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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     *
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set roles
     *
     * @param array $roles
     *
     * @return User
     */
    public function setRoles($roles)
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Get roles
     *
     * @return array
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * Set role
     *
     * @param array $role
     *
     * @return User
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return array
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add adresse
     *
     * @param \MP\PlatformBundle\Entity\Adresse $adresse
     *
     * @return User
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

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add favori
     *
     * @param \MP\PlatformBundle\Entity\Advert $favori
     *
     * @return User
     */
    public function addFavori(\MP\PlatformBundle\Entity\Advert $favori)
    {
        $this->favoris[] = $favori;

        return $this;
    }

    /**
     * Remove favori
     *
     * @param \MP\PlatformBundle\Entity\Advert $favori
     */
    public function removeFavori(\MP\PlatformBundle\Entity\Advert $favori)
    {
        $this->favoris->removeElement($favori);
    }

    /**
     * Get favoris
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFavoris()
    {
        return $this->favoris;
    }

    /**
     * Set adresse
     *
     * @param \MP\PlatformBundle\Entity\Adresse $adresse
     *
     * @return User
     */
    public function setAdresse(\MP\PlatformBundle\Entity\Adresse $adresse = null)
    {
        $this->adresse = $adresse;

        return $this;
    }
}
