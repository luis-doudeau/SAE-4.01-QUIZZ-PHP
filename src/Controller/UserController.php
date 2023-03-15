<?php

namespace App\Controller;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Entity\Reponse;
use App\Form\AnswerQuestionnaireType;
use App\Repository\QuestionnaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

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


        #[Route('/user/score/{id}', name: 'app_questionnaire_score')]
        public function submit(Request $request, int $id, EntityManagerInterface $entityManager): Response
        {
            $questionnaire = $entityManager->getRepository(Questionnaire::class)->find($id);
            if (!$questionnaire) {
                throw $this->createNotFoundException('Questionnaire not found');
            }
        
            $submittedData = $request->request->all();
            $submittedAnswers = [];
            foreach ($submittedData as $key => $value) {
                if (str_starts_with($key, 'answer')) {
                    $questionId = substr($key, 7, 9); // Extract the question ID from the key

                    $submittedAnswers[$questionId] = $value;
                }
            }

            $userScore = 0;
        
            // Process submitted answers and calculate the score
            $answeredQuestions = [];
            foreach ($questionnaire->getQuestions() as $question) {
                $questionId = $question->getId();
                $answerId = $submittedAnswers[$questionId] ?? null;
                if ($answerId !== null) {
                    $answer = $entityManager->getRepository(Reponse::class)->find($answerId);
                    $answeredQuestions[$questionId] = $answer;
                    if ($answer && $answer->getEstCorrect()) {
                        $userScore += $question->getPointQuestion();
                    }
                }
            }
            // Render the results template
            return $this->render('user/score.html.twig', [
                'questionnaire' => $questionnaire,
                'userScore' => $userScore,
                'answeredQuestions' => $answeredQuestions,
            ]);
        }
        


}

