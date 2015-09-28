<?php

namespace KG\BeekeepingManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * RecolteRucher
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class RecolteRucher
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Rucher
     * 
     * @ORM\ManyToOne(targetEntity="KG\BeekeepingManagementBundle\Entity\Rucher", inversedBy="recoltesrucher")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rucher;    

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     * @Assert\DateTime()
     */
    private $date;   

    /**
     * @ORM\OneToMany(targetEntity="KG\BeekeepingManagementBundle\Entity\RecolteRuche", mappedBy="ruche")
     * @Assert\Valid()
     */
    private $recoltesruche;
    
   /**
   * @Assert\Callback
   */
    public function isContentValid(ExecutionContextInterface $context)
    {       
        foreach( $this->getColonie()->getRecoltes() as $lastRecolte ){
            if ( $this->date < $lastRecolte->getDate()  && $lastRecolte->getId() != $this->getId() ){                
                $context
                       ->buildViolation('La date ne peut pas être antérieur ou égale à celle d\'une ancienne récolte') 
                       ->atPath('date')
                       ->addViolation();
            }            
        }
        
        $today = new \DateTime();
        
        if( $this->date > $today ){
            $context
                   ->buildViolation('La date ne peut pas être située dans le futur') 
                   ->atPath('date')
                   ->addViolation();            
        }
    }     
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->hausses = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Recolte
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set colonie
     *
     * @param \KG\BeekeepingManagementBundle\Entity\Colonie $colonie
     * @return Recolte
     */
    public function setColonie(\KG\BeekeepingManagementBundle\Entity\Colonie $colonie)
    {
        $this->colonie = $colonie;

        return $this;
    }

    /**
     * Get colonie
     *
     * @return \KG\BeekeepingManagementBundle\Entity\Colonie 
     */
    public function getColonie()
    {
        return $this->colonie;
    }

    /**
     * Add hausses
     *
     * @param \KG\BeekeepingManagementBundle\Entity\Hausse $hausses
     * @return Recolte
     */
    public function addHauss(\KG\BeekeepingManagementBundle\Entity\Hausse $hausses)
    {
        $this->hausses[] = $hausses;

        return $this;
    }

    /**
     * Remove hausses
     *
     * @param \KG\BeekeepingManagementBundle\Entity\Hausse $hausses
     */
    public function removeHauss(\KG\BeekeepingManagementBundle\Entity\Hausse $hausses)
    {
        $this->hausses->removeElement($hausses);
    }

    /**
     * Get hausses
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getHausses()
    {
        return $this->hausses;
    }

    /**
     * Set rucher
     *
     * @param \KG\BeekeepingManagementBundle\Entity\Rucher $rucher
     * @return RecolteRucher
     */
    public function setRucher(\KG\BeekeepingManagementBundle\Entity\Rucher $rucher)
    {
        $this->rucher = $rucher;

        return $this;
    }

    /**
     * Get rucher
     *
     * @return \KG\BeekeepingManagementBundle\Entity\Rucher 
     */
    public function getRucher()
    {
        return $this->rucher;
    }

    /**
     * Add recoltesruche
     *
     * @param \KG\BeekeepingManagementBundle\Entity\RecolteRuche $recoltesruche
     * @return RecolteRucher
     */
    public function addRecoltesruche(\KG\BeekeepingManagementBundle\Entity\RecolteRuche $recoltesruche)
    {
        $this->recoltesruche[] = $recoltesruche;

        return $this;
    }

    /**
     * Remove recoltesruche
     *
     * @param \KG\BeekeepingManagementBundle\Entity\RecolteRuche $recoltesruche
     */
    public function removeRecoltesruche(\KG\BeekeepingManagementBundle\Entity\RecolteRuche $recoltesruche)
    {
        $this->recoltesruche->removeElement($recoltesruche);
    }

    /**
     * Get recoltesruche
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRecoltesruche()
    {
        return $this->recoltesruche;
    }
}
