<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'login_check', methods:["POST", "GET"])]
    public function index(Request $request, Security $security, UserRepository $usermanager): Response
    {
        $username = $request->request->get('_email');
        $password = $request->request->get('_password');
        $users = $usermanager->findOneBy(["email"=>$username, "password"=>$password]);
        if($users != null && in_array("ROLE_USER", $users->getRoles())){
            return $this->redirectToRoute('app_user');
        }
        else if ($users != null && in_array("ROLE_ADMIN", $users->getRoles())){
            return $this->redirectToRoute('app_admin'); // Update this line with the correct route name for the CRUD questionnaire page
        }
        
        return $this->render('login/login.html.twig', [
            'controller_name' => 'LoginController',
            
        ]);
    }
}
    