<?php

namespace App\Controller;

use App\Entity\Question;
use App\Form\QuestionType;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/question/crud')]
class QuestionCrudController extends AbstractController
{
    #[Route('/', name: 'app_question_crud_index', methods: ['GET'])]
    public function index(QuestionRepository $questionRepository, ReponseRepository $reponseRepository): Response
    {
        return $this->render('question_crud/index.html.twig', [
            'questions' => $questionRepository->findAll(),
            'reponses' => $reponseRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_question_crud_new', methods: ['GET', 'POST'])]
    public function new(Request $request, QuestionRepository $questionRepository): Response
    {
        $question = new Question();
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_question_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question_crud/new.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_crud_show', methods: ['GET'])]
    public function show(Question $question, ReponseRepository $reponseRepository): Response
    {
        $reponses = $reponseRepository->findBy(['question' => $question]);

        return $this->render('question_crud/show.html.twig', [
            'question' => $question,
            'reponses' => $reponses
        ]);
    }

    #[Route('/{id}/edit', name: 'app_question_crud_edit', methods: ['GET', 'POST'])]
    #[ParamConverter("question", class: Question::class)]
    public function edit(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $questionRepository->save($question, true);

            return $this->redirectToRoute('app_question_crud_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('question_crud/edit.html.twig', [
            'question' => $question,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_question_crud_delete', methods: ['POST'])]
    public function delete(Request $request, Question $question, QuestionRepository $questionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$question->getId(), $request->request->get('_token'))) {
            $questionRepository->remove($question, true);
        }

        return $this->redirectToRoute('app_question_crud_index', [], Response::HTTP_SEE_OTHER);
    }
}
