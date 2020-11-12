<?php

namespace App\Controller;

use App\Entity\Room;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\BL\RoomManager;
use App\Form\RoomFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class RoomController extends AbstractController
{

    /**
     * @var EntityManagerInterface
     */
    private $em;

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
     * @Route("/rooms", name="GetListRoom")
     * @return Response
     */
    public function getRoomList()
    {

        $listRoom =  $this->roomManager->getListRoom();
        return $this->render('room/index.html.twig', ['listRoom' => $listRoom]);
    }

    /**
     * @Route("/room/add", name="addroom")
     * @param Request $request
     * @return Response
     */
    public function getAddAgent(Request $request)
    {

        $room = new Room();
        $form = $this->createForm(RoomFormType::class, $room);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->roomManager->GetInscriptionData($room);
            return $this->redirectToRoute('GetListRoom');
        }
        return $this->render('room/roomAdd.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/editRoom/{idRoom}", name="editRoom")
     * @param $idRoom
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function getModifyAgent($idRoom, Request $request)
    {
        $room = $this->roomManager->getRoomById($idRoom);
        $form = $this->createForm(RoomFormType::class, $room);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->roomManager->GetInscriptionData($room);
            return $this->redirectToRoute('GetListRoom');
        }
        return $this->render('room/roomEdit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/deleteRoom/{idRoom}",name="deleteRoom")
     * @param $idRoom
     * @return RedirectResponse|Response
     */
    public function deleteRoom($idRoom)
    {
        $room = $this->roomManager->getRoomById($idRoom);
        $this->roomManager->deleteRoom($room);
        return $this->redirectToRoute('GetListRoom');
    }

   
}
