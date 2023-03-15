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


        #[Route('/user/start/{questionnaire}', name: 'app_questionnaire_start')]
        public function start(Questionnaire $questionnaire): Response
        {
            return $this->render('user/start.html.twig', [
                'questionnaire' => $questionnaire,
            ]);
        }


    /**
     * @Route("/questionnaire/{id}/answer/submit", name="app_questionnaire_answer_submit", methods={"POST"})
     */
    #[Route('/user/score/{questionnaire}', name: 'app_questionnaire_score')]
    public function submit(Request $request, Questionnaire $questionnaire)
{
    $submittedAnswers = $request->request->get('answer');

    if (is_array($submittedAnswers)) {
        // Process the submitted answers as an array
    } elseif (is_object($submittedAnswers)) {
        // Process the submitted answers as an object
    } else {
        // Throw an error or handle the case when the input value is not an array or object
    }

    // Check submitted answers
    $score = 0;
    $correctAnswersPerQuestion = [];
    foreach ($submittedAnswers as $questionId => $answerIds) {
        $question = $this->getDoctrine()->getRepository(Question::class)->find($questionId);

        if (!$question) {
            throw $this->createNotFoundException('Question not found');
        }

        // Store correct answers for this question
        $correctAnswers = $question->getCorrectAnswers();
        $correctAnswersPerQuestion[$questionId] = $correctAnswers;

        // Check answers for multiple choice questions (checkboxes)
        // ...
    }

    return $this->render('user/score_and_correction.html.twig', [
        'questionnaire' => $questionnaire,
        'score' => $score,
        'correctAnswersPerQuestion' => $correctAnswersPerQuestion,
    ]);
}
}
