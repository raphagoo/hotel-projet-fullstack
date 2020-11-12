<?php

namespace App\BL;
use App\Entity\Option;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AdminManager
 * @package App\BL
 */
class OptionManager
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;


    /**
     * @return Option[]
     */
    public function getOptionList(){
        return $this->em->getRepository(Option::class)->findAll();

    }

    /**
     * @param $idOption
     * @return Option|object|null
     */
    public function getOptionById($idOption)
    {
        return $this->em->getRepository(Option::class)->find($idOption);
    }

    /**
     * @param Option $newOption
     */
    public function GetInscriptionData(Option $newOption){
        
        $this->em->persist($newOption);
        $this->em->flush();
    }

    /**
     * @param $option
     */
    public function editOption($option)
    {
        $this->em->persist($option);
        $this->em->flush();
    }

    /**
     * @param $option
     */
    public function deleteOption($option)
    {
        $this->em->remove($option);
        $this->em->flush();
    }

}