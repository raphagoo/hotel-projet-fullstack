<?php

namespace App\Controller;

use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\BL\RoomManager;
use Doctrine\ORM\EntityManagerInterface;

class RoomController extends AbstractController
{

    public function __construct(EntityManagerInterface $em)
    {
        
        $this->roomManager = new RoomManager($em);
        $this->em = $em;
    }

    /**
     * @var RoomManager
     */
    private $roomManager;

    /**
     * @Route("/room", name="GetListRoom")
     * @return Response
     */
    public function getRoomList(){

        $listRoom =  $this->roomManager->getListRoom();
        return $this->render('room/index.html.twig', ['listRoom' => $listRoom]);
    }

/**
     * @param $idRoom
     * @Route("/room/{idRoom}", name="getRoomById")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getRoomById($idRoom)
    {
        $room = $this->roomManager->getRoomById($idRoom);

        return $this->render('room/room.html.twig', array(
            "room" => $room
        ));
    }
     
}
