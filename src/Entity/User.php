<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Result;

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;


    /**
     * @Assert\NotBlank()
     *  @ORM\Column(type="string", length=64)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $secondname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $thirdname;


    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * The below length depends on the "algorithm" you use for encoding
     * the password, but this works well with bcrypt.
     *
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getcity()
    {
        return $this->city;
    }

    public function setcity($city)
    {
        $this->city = $city;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function setFirstname($username)
    {
        $this->firstname = $username;
    }

    public function getSecondname()
    {
        return $this->secondname;
    }

    public function setSecondname($username)
    {
        $this->secondname = $username;
    }

    public function getThirdname()
    {
        return $this->thirdname;
    }

    public function setThirdname($username)
    {
        $this->thirdname = $username;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getSalt()
    {
        return null;
    }

    public function eraseCredentials()
    {
    }

    /**
     * @var ArrayCollection
     * @ORM\Column(type="array")
     */
    private $roles;

    public function __construct()
    {
        $this->roles = ["ROLE_USER"];
        $this->resultList = new ArrayCollection();
    }

    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @ORM\OneToMany(targetEntity="Result", mappedBy="user")
     * @ORM\JoinColumn(name="list_of_results", referencedColumnName="id")
     *
     */
    private $resultList;

    /**
     * @return Collection|Result[]
     */
    public function getResultList()
    {
        return $this->resultList;
    }

    /**
     * @param mixed $result
     */
    public function setResultList(Result $result): void
    {
        $this->resultList->add($result);
    }
}
