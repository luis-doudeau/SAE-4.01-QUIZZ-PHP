<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\QuestionnaireRepository;
use App\Entity\Questionnaire;
use App\Form\QuestionnaireImageType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(QuestionnaireRepository $questionnaireRepository): Response
    {
        $questionnaires = $questionnaireRepository->findAll();
        $forms = [];
        foreach ($questionnaires as $questionnaire) {
            $forms[$questionnaire->getId()] = $this->createForm(QuestionnaireImageType::class, $questionnaire)->createView();
        }

        return $this->render('admin/index.html.twig', [
            'questionnaires' => $questionnaires,
            'forms' => $forms
        ]);
    }

    #[Route('/admin/questionnaire/{id}/upload-image', name: 'app_admin_questionnaire_upload_image', methods: ['POST'])]
    public function uploadQuestionnaireImage(Request $request, Questionnaire $questionnaire): Response
    {
        $form = $this->createForm(QuestionnaireImageType::class, $questionnaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile $imageFile */
            $imageFile = $form['image']->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('questionnaire_image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $questionnaire->setImage($newFilename);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($questionnaire);
                $entityManager->flush();
            }

            return $this->redirectToRoute('app_admin');
        }

        // ... render a form or error page if the form is not submitted or not valid
    }
}
