<?php

namespace App\Controller;

use App\Repository\QuestionnaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionnaireController extends AbstractController
{
    #[Route('/questionnaires', name: 'app_questionnaire')]
    public function index(QuestionnaireRepository $questionnaireManager): Response
    {
        $questionnaires = $questionnaireManager->findAll();
        return $this->render('questionnaire/index.html.twig', [
            'controller_name' => 'QuestionnaireController',
            "questionnaires" => $questionnaires
        ]);
    }


    #[Route('/questionnaires/{id}', name: 'questionnaire_details')]
    public function show($id, QuestionnaireRepository $questionnaireManager): Response
    {
        
        $questionnaire = $questionnaireManager->findOneBy(["id"=>$id]);

        return $this->render('app_questionnaire_crud_controlleur_show', [
            'questionnaire' => $questionnaire,
        ]);
    }
}
