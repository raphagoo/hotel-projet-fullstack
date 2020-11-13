<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 17/12/2018
 * Time: 17:19
 */

namespace App\BL;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AdminManager
 * @package App\BL
 */
class UserManager
{
 
    /**
     * @var ManagerRegistry
     */
    private $registry;

    public function __construct(ManagerRegistry $registry,EntityManagerInterface $em)
    {
        $this->em = $em;
        $this->registry = $registry;
        
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

    /**
     * @param $idUser
     * @param $role
     * @param Request $request
     * @return PaginationInterface
     */
    public function updateUserRoleAdmin($role, $idUser, Request $request)
    {
         $repository = new UserRepository($this->registry);
         $repository->updateRoleUser($role, $idUser, $request);
         return true;
    }

    public function updateUserRoleUser($role, $idUser, Request $request)
    {
         $repository = new UserRepository($this->registry);
         $repository->updateRoleUser($role, $idUser, $request);
         return false;
    }
}
