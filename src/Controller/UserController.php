<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Form\AnswerQuestionnaireType;
use App\Repository\QuestionnaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(QuestionnaireRepository $questionnaireRepository): Response
    {
        // Get all questionnaires
        $questionnaires = $questionnaireRepository->findAll();

        // Render template
        return $this->render('user/index.html.twig', [
            'questionnaires' => $questionnaires
        ]);
    }

    #[Route('/user/start/{questionnaire}/{questionNumber}', name: 'app_questionnaire_start')]
    public function start(Questionnaire $questionnaire, int $questionNumber = 1, Request $request): Response    {
        $question = $questionnaire->getQuestions()[$questionNumber - 1];

        // Create the form to answer the questionnaire for the current question
        $form = $this->createForm(AnswerQuestionnaireType::class, null, ['question' => $question]);

        // Check if form is submitted and valid
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Save answers and redirect user to the next page of the questionnaire
            // ...
        }

        // Point counter for the current question
        $pointQuestion = $question->getPointQuestion();

        return $this->render('user/start.html.twig', [
            'questionnaire' => $questionnaire,
            'question' => $question,
            'form' => $form->createView(),
            'questionNumber' => $questionNumber,
            'pointQuestion' => $pointQuestion,
            'totalQuestions' => count($questionnaire->getQuestions()),
        ]);
    }

    /**
     * @Route("/questionnaire/{id}/answer/submit", name="app_questionnaire_answer_submit", methods={"POST"})
     */
    public function submit(Request $request, Questionnaire $questionnaire)
    {
        $submittedAnswers = $request->request->get('answer');

        // Check submitted answers
        $score = 0;
        foreach ($submittedAnswers as $questionId => $answerIds) {
            $question = $this->getDoctrine()->getRepository(Question::class)->find($questionId);

            if (!$question) {
                throw $this->createNotFoundException('Question not found');
            }

            // Check answers for multiple choice questions (checkboxes)
            if ($question->getType() === 'checkbox') {
                $correctAnswerIds = $question->getCorrectAnswers()->map(function ($answer) {
                    return $answer->getId();
                })->toArray();

                sort($answerIds);
                sort($correctAnswerIds);

                if ($answerIds === $correctAnswerIds) {
                    $score += $question->getPointQuestion();
                }

            // Check answers for single choice questions (radio buttons)
            } elseif ($question->getType() === 'radio') {
                $correctAnswerId = $question->getCorrectAnswers()[0]->getId();

                if ($answerIds == $correctAnswerId) {
                    $score += $question->getPointQuestion();
                }
            }
        }

        return $this->render('questionnaire_answer/submit.html.twig', [
            'questionnaire' => $questionnaire,
            'score' => $score,
        ]);
    }
}
