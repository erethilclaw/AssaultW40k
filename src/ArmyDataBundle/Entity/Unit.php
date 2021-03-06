<?php

namespace ArmyDataBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Unit
 *
 * @ORM\Table(name="unit")
 * @ORM\Entity(repositoryClass="ArmyDataBundle\Repository\UnitRepository")
 */
class Unit
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
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="Ha", type="integer")
     */
    private $ha;

    /**
     * @var int
     *
     * @ORM\Column(name="Hp", type="integer")
     */
    private $hp;

    /**
     * @var int
     *
     * @ORM\Column(name="F", type="integer")
     */
    private $f;

    /**
     * @var int
     *
     * @ORM\Column(name="R", type="integer")
     */
    private $r;

    /**
     * @var int
     *
     * @ORM\Column(name="H", type="integer")
     */
    private $h;

    /**
     * @var int
     *
     * @ORM\Column(name="I", type="integer")
     */
    private $i;

    /**
     * @var int
     *
     * @ORM\Column(name="A", type="integer")
     */
    private $a;

    /**
     * @var int
     *
     * @ORM\Column(name="L", type="integer")
     */
    private $l;

    /**
     * @var int
     *
     * @ORM\Column(name="S", type="integer")
     */
    private $s;


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
     * @return Unit
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
     * Set ha
     *
     * @param integer $ha
     *
     * @return Unit
     */
    public function setHa($ha)
    {
        $this->ha = $ha;

        return $this;
    }

    /**
     * Get ha
     *
     * @return int
     */
    public function getHa()
    {
        return $this->ha;
    }

    /**
     * Set hp
     *
     * @param integer $hp
     *
     * @return Unit
     */
    public function setHp($hp)
    {
        $this->hp = $hp;

        return $this;
    }

    /**
     * Get hp
     *
     * @return int
     */
    public function getHp()
    {
        return $this->hp;
    }

    /**
     * Set f
     *
     * @param integer $f
     *
     * @return Unit
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
     * Set r
     *
     * @param integer $r
     *
     * @return Unit
     */
    public function setR($r)
    {
        $this->r = $r;

        return $this;
    }

    /**
     * Get r
     *
     * @return int
     */
    public function getR()
    {
        return $this->r;
    }

    /**
     * Set h
     *
     * @param integer $h
     *
     * @return Unit
     */
    public function setH($h)
    {
        $this->h = $h;

        return $this;
    }

    /**
     * Get h
     *
     * @return int
     */
    public function getH()
    {
        return $this->h;
    }

    /**
     * Set i
     *
     * @param integer $i
     *
     * @return Unit
     */
    public function setI($i)
    {
        $this->i = $i;

        return $this;
    }

    /**
     * Get i
     *
     * @return int
     */
    public function getI()
    {
        return $this->i;
    }

    /**
     * Set a
     *
     * @param integer $a
     *
     * @return Unit
     */
    public function setA($a)
    {
        $this->a = $a;

        return $this;
    }

    /**
     * Get a
     *
     * @return int
     */
    public function getA()
    {
        return $this->a;
    }

    /**
     * Set l
     *
     * @param integer $l
     *
     * @return Unit
     */
    public function setL($l)
    {
        $this->l = $l;

        return $this;
    }

    /**
     * Get l
     *
     * @return int
     */
    public function getL()
    {
        return $this->l;
    }

    /**
     * Set s
     *
     * @param integer $s
     *
     * @return Unit
     */
    public function setS($s)
    {
        $this->s = $s;

        return $this;
    }

    /**
     * Get s
     *
     * @return int
     */
    public function getS()
    {
        return $this->s;
    }
}

