<?php

namespace ArmyDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Weapon
 *
 * @ORM\Table(name="weapon")
 * @ORM\Entity(repositoryClass="ArmyDataBundle\Repository\WeaponRepository")
 * @UniqueEntity("name")
 */
class Weapon
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
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="distance", type="integer")
     * @Assert\Range(
     *     min = 0,
     *     max= 120,
     *     minMessage="validation.weapon.min",
     *     maxMessage="validation.weapon.max"
     * )
     */
    private $distance;

    /**
     * @var int
     *
     * @ORM\Column(name="f", type="integer")
     */
    private $f;

    /**
     * @var int
     *
     * @ORM\Column(name="fp", type="integer")
     */
    private $fp;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     * @Assert\Choice({"Asalto","Pesada","Fuego Rapido","Artilleria"},
     *     message="validation.weapon.type")
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="shoots", type="integer")
     * @Assert\Range(
     *     min = 0,
     *     max= 120,
     *     minMessage="validation.weapon.min",
     *     maxMessage="validation.weapon.max"
     * )
     */
    private $shoots;

    /**
     * Many Weapons have many Armies
     * @ORM\ManyToMany(targetEntity="ArmyDataBundle\Entity\Army", mappedBy="weapons")
     */
    private $armies;

    /**
     * Many Weapons have many Units
     * @ORM\ManyToMany(targetEntity="Unit", mappedBy="weapons")
     */
    private $units;

    /**
     * @ORM\Column(type="string")
     *
     */
    private $image;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    public function __construct()
    {
        $this->armies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->units = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Weapon
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
     * Set distance
     *
     * @param integer $distance
     *
     * @return Weapon
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;

        return $this;
    }

    /**
     * Get distance
     *
     * @return int
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set f
     *
     * @param integer $f
     *
     * @return Weapon
     */
    public function setF($f)
    {
        $this->f = $f;

        return $this;
    }

    /**
     * Get f
     *
     * @return int
     */
    public function getF()
    {
        return $this->f;
    }

    /**
     * Set fp
     *
     * @param integer $fp
     *
     * @return Weapon
     */
    public function setFp($fp)
    {
        $this->fp = $fp;

        return $this;
    }

    /**
     * Get fp
     *
     * @return int
     */
    public function getFp()
    {
        return $this->fp;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Weapon
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getShoots()
    {
        return $this->shoots;
    }

    /**
     * @param int $shoots
     */
    public function setShoots($shoots)
    {
        $this->shoots = $shoots;
    }

    /**
     * @return mixed
     */
    public function getArmies()
    {
        return $this->armies;
    }

    /**
     * @param mixed $armies
     */
    public function setArmies($armies)
    {
        $this->armies = $armies;
    }

    /**
     * @param mixed $units
     */
    public function setUnits($units)
    {
        $this->units = $units;
    }



    /**
     * Add army
     *
     * @param $army
     *
     * @return Weapon
     */
    public function addArmies( \ArmyDataBundle\Entity\Army $army)
    {
        if (!$this->armies->contains($army)){
            $army->addWeapons($this);
            $this->armies->add($army);
        }
        return $this;
    }

    /**
     * Remove army
     *
     * @param $army
     */
    public function removeArmies( \ArmyDataBundle\Entity\Army $army)
    {
        $this->armies->removeElement($army);
    }

    /**
     *
     */
    public function clearArmies(){
        $this->armies->clear();
    }

    /**
     * @return mixed
     */
    public function getUnits()
    {
        return $this->units;
    }

    /**
     * Add unit
     *
     * @param $unit
     *
     * @return Weapon
     */
    public function addUnits( \ArmyDataBundle\Entity\Unit $unit)
    {
         if (!$this->units->contains($unit)){
             $this->units = $unit;
             $unit->addWeapons($this);
         }
        return $this;
    }

    /**
     * Remove unit
     *
     * @param $unit
     */
    public function removeUnits( \ArmyDataBundle\Entity\Unit $unit)
    {
        $this->units->removeElement($unit);
    }

    /**
     *
     */
    public function clearUnits(){
        $this->units->clear();
    }

    public function __toString()
    {
        return (String)$this->name;
    }
}

