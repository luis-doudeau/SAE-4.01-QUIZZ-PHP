<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Entity\Reponse;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'un questionnaire
        $questionnaire = new Questionnaire();
        $questionnaire->setNomQuestionnaire('Questionnaire de satisfaction');
        $questionnaire->setTheme('Satisfaction client');

        // Création de questions
        $question1 = new Question();
        $question1->setNomQuestion('Êtes-vous satisfait de notre service client ?');
        $question1->setQuestionnaire($questionnaire);

        $question2 = new Question();
        $question2->setNomQuestion('Avez-vous trouvé facilement ce que vous cherchiez ?');
        $question2->setQuestionnaire($questionnaire);

        // Création de réponses
        $reponse1 = new Reponse();
        $reponse1->setNomReponse('Oui');
        $reponse1->setQuestion($question1);

        $reponse2 = new Reponse();
        $reponse2->setNomReponse('Non');
        $reponse2->setQuestion($question1);

        $reponse3 = new Reponse();
        $reponse3->setNomReponse('Oui');
        $reponse3->setQuestion($question2);

        $reponse4 = new Reponse();
        $reponse4->setNomReponse('Non');
        $reponse4->setQuestion($question2);

        $user = new User();
        $user->setPseudo("luigi");
        $user->setPassword("q");
        $user->setFullName("Luis DOUDEAU");
        $user->setEmail("luis.doudeau@gmail.com");

        $userAdmin = new User();
        $userAdmin->setPseudo("admin");
        $userAdmin->setPassword("admin");
        $userAdmin->setFullName("administrateur");
        $userAdmin->setEmail("admin@gmail.com");

        // Persistance des entités
        $manager->persist($questionnaire);
        $manager->persist($question1);
        $manager->persist($question2);
        $manager->persist($reponse1);
        $manager->persist($reponse2);
        $manager->persist($reponse3);
        $manager->persist($reponse4);
        $manager->persist($user);
        $manager->persist($userAdmin);

        $manager->flush();
    }
}

