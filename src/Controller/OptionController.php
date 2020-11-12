<?php

namespace App\Controller;

use App\Entity\Option;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\BL\OptionManager;
use App\Form\OptionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class OptionController extends AbstractController
{


   /**
     * @var EntityManagerInterface
     */
    private $em;

    

    public function __construct(EntityManagerInterface $em)
    {

        $this->optionManager = new OptionManager($em);
        $this->em = $em;
    }

    /**
     * @var OptionManager
     */
    private $optionManager;

    /**
     * @Route("/backoffice/options", name="GetListOption")
     * @return Response
     */
    public function getOptionList()
    {

        $listOption =  $this->optionManager->getOptionList();
        return $this->render('backoffice/option/index.html.twig', ['listOption' => $listOption]);
    }


    /**
     * @Route("/backoffice/option/add", name="addOption")
     * @param Request $request
     * @return Response
     */
    public function getAddAgent(Request $request)
    {

        $option = new Option();
        $form = $this->createForm(OptionFormType::class, $option);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->optionManager->GetInscriptionData($option);
            return $this->redirectToRoute('GetListOption');
        }
        return $this->render('backoffice/option/optionAdd.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/backoffice/option/edit/{idOption}", name="editOption")
     * @param $idOption
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function getModifyAgent($idOption, Request $request)
    {
        $option = $this->optionManager->getOptionById($idOption);
        $form = $this->createForm(OptionFormType::class, $option);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->optionManager->GetInscriptionData($option);
            return $this->redirectToRoute('GetListOption');
        }
        return $this->render('backoffice/option/optionEdit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/backoffice/option/delete/{idOption}",name="deleteOption")
     * @param $idOption
     * @return RedirectResponse|Response
     */
    public function deleteRoom($idOption)
    {
        $option = $this->optionManager->getOptionById($idOption);
        $this->optionManager->deleteOption($option);
        return $this->redirectToRoute('GetListOption');
    }

    

}