<?php

namespace ArmyDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Army
 *
 * @ORM\Table(name="army")
 * @ORM\Entity(repositoryClass="ArmyDataBundle\Repository\ArmyRepository")
 * @UniqueEntity("name")
 */
class Army
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
     * One army has Many Units
     * @ORM\OneToMany(targetEntity="ArmyDataBundle\Entity\Unit", mappedBy="army")
     */
    private $units;

    /**
     * Many armies has Many Weapons
     * @ORM\ManyToMany(targetEntity="Weapon",cascade={"persist"}, fetch="EXTRA_LAZY", inversedBy="armies")
     */
    private $weapons;

    /**
     * @ORM\Column(type="string")
     *
     */
    private $image;

    public function __construct()
    {
        $this->units = new \Doctrine\Common\Collections\ArrayCollection();
        $this->weapons = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Army
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

    public function __toString()
    {
        return (String)$this->name;
    }

    /**
     * @return mixed
     */
    public function getUnits()
    {
        return $this->units;
    }

    public function addUnit( \ArmyDataBundle\Entity\Unit $unit)
    {
        $unit->addWeapon($this);
        $this->units->add($unit);

        return $this;
    }

    /**
     * Remove unit
     *
     * @param $unit
     */
    public function removeUnit( \ArmyDataBundle\Entity\Unit $unit)
    {
        $this->units->removeElement($unit);
    }

    /**
     *
     */
    public function clearUnits(){
        $this->units->clear();
    }

    /**
     * @return mixed
     */
    public function getWeapons()
    {
        return $this->weapons;
    }

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



    public function addWeapons( \ArmyDataBundle\Entity\Weapon $weapon)
    {
        if (!$this->weapons->contains($weapon)) {
            $weapon->addArmies($this);
            $this->weapons->add($weapon);
        }
        return $this;
    }

    /**
     * Remove unit
     *
     * @param $unit
     */
    public function removeWeapons( \ArmyDataBundle\Entity\Weapon $weapon)
    {
        $this->weapons->removeElement($weapon);
    }

    /**
     *
     */
    public function clearWeapons(){
        $this->weapons->clear();
    }

}

