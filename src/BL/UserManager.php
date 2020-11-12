<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 17/12/2018
 * Time: 17:19
 */

namespace App\BL;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AdminManager
 * @package App\BL
 */
class UserManager
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;


    /**
     * @return User[]
     */
    public function getListUser(){
        return $this->em->getRepository(User::class)->findAll();
    }

    /**
     * @param $idUser
     * @return User|object|null
     */
    public function getUserById($idUser)
    {
        return $this->em->getRepository(User::class)->find($idUser);
    }

    public function saveData($data){
        $this->em->persist($data);
        $this->em->flush();
    }


    /**
     * @param $user
     */
    public function deleteRoom($user)
    {
        $this->em->remove($user);
        $this->em->flush();
    }
}
