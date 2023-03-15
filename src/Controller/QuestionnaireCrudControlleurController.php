<?php

namespace App\Controller;

use App\Entity\Questionnaire;
use App\Form\QuestionnaireType;
use App\Repository\QuestionnaireRepository;
use App\Repository\QuestionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/questionnaire/crud')]
class QuestionnaireCrudControlleurController extends AbstractController
{
    #[Route('/', name: 'app_questionnaire_crud_controlleur_index', methods: ['GET'])]
    public function index(QuestionnaireRepository $questionnaireRepository): Response
    {
        return $this->render('questionnaire_crud_controlleur/index.html.twig', [
            'questionnaires' => $questionnaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_questionnaire_crud_controlleur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuestionnaireRepository $questionnaireRepository): Response
    {
        $questionnaire = new Questionnaire();
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaireRepository->save($questionnaire, true);

            return $this->redirectToRoute('app_questionnaire_crud_controlleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire_crud_controlleur/new.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_questionnaire_crud_controlleur_show', methods: ['GET'])]
    public function show(Questionnaire $questionnaire): Response
    {
        return $this->render('questionnaire_crud_controlleur/show.html.twig', [
            'questionnaire' => $questionnaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_questionnaire_crud_controlleur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Questionnaire $questionnaire, QuestionnaireRepository $questionnaireRepository): Response
    {
        $form = $this->createForm(QuestionnaireType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionnaireRepository->save($questionnaire, true);

            return $this->redirectToRoute('app_questionnaire_crud_controlleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('questionnaire_crud_controlleur/edit.html.twig', [
            'questionnaire' => $questionnaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_questionnaire_crud_controlleur_delete', methods: ['POST'])]
    public function delete(Request $request, Questionnaire $questionnaire, QuestionnaireRepository $questionnaireRepository, QuestionRepository $questionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$questionnaire->getId(), $request->request->get('_token'))) {
            $questionnaireRepository->remove($questionnaire, true);
        }

        return $this->redirectToRoute('app_questionnaire_crud_controlleur_index', [], Response::HTTP_SEE_OTHER);
    }

}
