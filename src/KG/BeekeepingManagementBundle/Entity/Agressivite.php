<?php

namespace KG\BeekeepingManagementBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Agressivite
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="KG\BeekeepingManagementBundle\Entity\AgressiviteRepository")
 * @UniqueEntity(fields="libelle", message="Une agressivité existe déjà avec ce libellé")
 */
class Agressivite
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
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=25, unique=true)  
     * @Assert\NotBlank(message="Veuillez remplir le libellé de l'agressivité")
     * @Assert\Length(max=25, maxMessage="Le libellé de l'agressivité ne peut dépasser {{ limit }} caractères")
     */
    private $libelle;


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
     * Set libelle
     *
     * @param string $libelle
     * @return Agressivite
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string 
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
}