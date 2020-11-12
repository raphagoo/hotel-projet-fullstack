<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    public $title = "Hotel Projet";

    /**
     * @Route("/", name="index")
     */
    public function index(): Response
    {
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
        ]);
    }

    /**
     * @Route("/backoffice", name="backoffice")
     */
    public function backofficeIndex(): Response
    {
        return $this->render('backoffice/index.html.twig');
    }
}
