<?php
/**
 * Created by IntelliJ IDEA.
 * User: RAGOSTINI
 * Date: 17/12/2018
 * Time: 17:19
 */

namespace App\BL;
use App\Entity\Room;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Tests\Controller;

/**
 * Class AdminManager
 * @package App\BL
 */
class RoomManager
{

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /*** @var EntityManagerInterface l'interface entity manager* nécessaire à la manipulation des opérations en base*/
    protected $em;


    /**
     * @return Room[]
     */
    public function getListRoom(){
        return $this->em->getRepository(Room::class)->findAll();

    }

    /**
     * @param $idRoom
     * @return Room|object|null
     */
    public function getRoomById($idRoom)
    {
        $room = $this->em->getRepository(Room::class)->find($idRoom);
        return $room;
    }

        /**
     * @param Room $room
     */
    public function GetInscriptionData(Room $newRoom){
        
        $this->em->persist($newRoom);
        $this->em->flush();
    }

       /**
     * @param $user
     */
    public function editRoom($room)
    {
        $this->em->persist($room);
        $this->em->flush();
    }

    /**
     * @param $user
     */
    public function deleteRoom($room)
    {
        $this->em->remove($room);
        $this->em->flush();
    }

}
