<?php

namespace App\Controller;

use App\BL\UserManager;
use App\Entity\User;
use App\Form\UserFormAddType;
use App\Form\UserFormEditType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var UserManager
     */
    private $userManager;

    public function __construct(EntityManagerInterface $em)
    {

        $this->userManager = new UserManager($em);
        $this->em = $em;
    }
    /**
     * @Route("/backoffice/users", name="users")
     */
    public function index(): Response
    {
        $users = $this->userManager->getListUser();
        dump($users);
        return $this->render('backoffice/user/index.html.twig', [
            'users' => $users,
        ]);
    }

    /**
     * @Route("/backoffice/users/add", name="userAdd")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function addUser(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $user = new User();
        $form = $this->createForm(UserFormAddType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $password = $passwordEncoder->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_USER"]);
            $this->userManager->saveData($user);
            return $this->redirectToRoute('users');
        }
        return $this->render('backoffice/user/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/backoffice/users/{idUser}", name="userModify")
     * @param $idUser
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function updateUser($idUser, Request $request, UserPasswordEncoderInterface $passwordEncoder){
        $user = $this->userManager->getUserById($idUser);
        $oldPassword = $this->userManager->getUserById($idUser)->getPassword();
        $form = $this->createForm(UserFormEditType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if(!empty($form->get('password')->getData())) {
                $password = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($password);
            }
            else{
                $user->setPassword($oldPassword);
            }
            $this->userManager->saveData($user);
            return $this->redirectToRoute('users');
        }
        return $this->render('backoffice/user/modify.html.twig', ['form' => $form->createView()]);
    }
}
