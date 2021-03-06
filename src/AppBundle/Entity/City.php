<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CityFixtures
 *
 * @ORM\Table(name="city")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CityRepository")
 */
class City
{
    public function __toString()
    {
        return $this->getName();
    }

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
     * @var Promo
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Promo", mappedBy="city")
     */
    private $promo;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return City
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->promo = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add promo.
     *
     * @param \AppBundle\Entity\Promo $promo
     *
     * @return City
     */
    public function addPromo(\AppBundle\Entity\Promo $promo)
    {
        $this->promo[] = $promo;

        return $this;
    }

    /**
     * Remove promo.
     *
     * @param \AppBundle\Entity\Promo $promo
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removePromo(\AppBundle\Entity\Promo $promo)
    {
        return $this->promo->removeElement($promo);
    }

    /**
     * Get promo.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPromo()
    {
        return $this->promo;
    }
}
