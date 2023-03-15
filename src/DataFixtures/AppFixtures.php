<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Questionnaire;
use App\Entity\Reponse;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

// src/DataFixtures/AppFixtures.php

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
        $question2 = new Question();

        // Création de réponses
        $reponse1 = new Reponse();
        $reponse1->setNomReponse('Oui');
        $reponse1->setQuestion($question1);
        $reponse1->setEstCorrect(true);

        $reponse2 = new Reponse();
        $reponse2->setNomReponse('Non');
        $reponse2->setQuestion($question1);
        $reponse2->setEstCorrect(false);


        $reponse3 = new Reponse();
        $reponse3->setNomReponse('Oui');
        $reponse3->setQuestion($question2);
        $reponse3->setEstCorrect(true);

        $reponse4 = new Reponse();
        $reponse4->setNomReponse('Non');
        $reponse4->setQuestion($question2);
        $reponse4->setEstCorrect(false);

        $manager->persist($question1);
        $manager->persist($question2);
        $manager->persist($reponse1);
        $manager->persist($reponse2);
        $manager->persist($reponse3);
        $manager->persist($reponse4);

        // set des bonne(s) réponse(s) sur les questions
        $question1->setNomQuestion('Êtes-vous satisfait de notre service client ?');
        $question1->setQuestionnaire($questionnaire);
        $question1->setPointQuestion(0);
        $question1->setTypeQuestion("unique");

        $question2->setNomQuestion('Avez-vous trouvé facilement ce que vous cherchiez ?');
        $question2->setQuestionnaire($questionnaire);
        $question2->setPointQuestion(0);
        $question2->setTypeQuestion("unique");

        $user = new User();
        $user->setPseudo("luigi");
        $user->setPassword("q");
        $user->setFullName("Luis DOUDEAU");
        $user->setEmail("luis.doudeau@gmail.com");
        $user->setRoles(["ROLE_USER"]);

        $userAdmin = new User();
        $userAdmin->setPseudo("admin");
        $userAdmin->setPassword("admin");
        $userAdmin->setFullName("administrateur");
        $userAdmin->setEmail("admin@gmail.com");
        $userAdmin->setRoles(["ROLE_ADMIN"]);

        // Persistance des entités
        $manager->persist($questionnaire);
        $manager->persist($user);
        $manager->persist($userAdmin);



        // Création d'un deuxième questionnaire
        $questionnaire2 = new Questionnaire();
        $questionnaire2->setNomQuestionnaire('Questionnaire de sport');
        $questionnaire2->setTheme('Sport');

        // Création de questions pour le deuxième questionnaire
        $question3 = new Question();
        $question4 = new Question();
        $question5 = new Question();

        // Création de réponses pour le deuxième questionnaire
        $reponse5 = new Reponse();
        $reponse5->setNomReponse('Football');
        $reponse5->setQuestion($question3);
        $reponse5->setEstCorrect(true);

        $reponse6 = new Reponse();
        $reponse6->setNomReponse('Basketball');
        $reponse6->setQuestion($question3);
        $reponse6->setEstCorrect(false);

        $reponse7 = new Reponse();
        $reponse7->setNomReponse('Tennis');
        $reponse7->setQuestion($question3);
        $reponse7->setEstCorrect(false);

        $reponse8 = new Reponse();
        $reponse8->setNomReponse('2');
        $reponse8->setQuestion($question4);
        $reponse8->setEstCorrect(true);

        $reponse9 = new Reponse();
        $reponse9->setNomReponse('3');
        $reponse9->setQuestion($question4);
        $reponse9->setEstCorrect(false);

        $reponse10 = new Reponse();
        $reponse10->setNomReponse('4');
        $reponse10->setQuestion($question4);
        $reponse10->setEstCorrect(false);

        $reponse11 = new Reponse();
        $reponse11->setNomReponse('Yes');
        $reponse11->setQuestion($question5);
        $reponse11->setEstCorrect(true);

        $reponse12 = new Reponse();
        $reponse12->setNomReponse('No');
        $reponse12->setQuestion($question5);
        $reponse12->setEstCorrect(false);

        $reponse13 = new Reponse();
        $reponse13->setNomReponse('Maybe');
        $reponse13->setQuestion($question5);
        $reponse13->setEstCorrect(false);

        $manager->persist($question3);
        $manager->persist($question4);
        $manager->persist($question5);
        $manager->persist($reponse5);
        $manager->persist($reponse6);
        $manager->persist($reponse7);
        $manager->persist($reponse8);
        $manager->persist($reponse9);
        $manager->persist($reponse10);
        $manager->persist($reponse11);
        $manager->persist($reponse12);
        $manager->persist($reponse13);

        // set des bonne(s) réponse(s) sur les questions pour le deuxième questionnaire
        $question3->setNomQuestion('Quel sont vos sports préférés ?');
        $question3->setQuestionnaire($questionnaire2);
        $question3->setPointQuestion(0);
        $question3->setTypeQuestion("multiple");

        $question4->setNomQuestion('Combien y a-t-il de joueurs dans une équipe de basketball ?');
        $question4->setQuestionnaire($questionnaire2);
        $question4->setPointQuestion(0);
        $question4->setTypeQuestion("unique");

        $question5->setNomQuestion('Aimez-vous regarder les compétitions sportives à la télévision ?');
        $question5->setQuestionnaire($questionnaire2);
        $question5->setPointQuestion(0);
        $question5->setTypeQuestion("unique");

        // Persistance des entités
        $manager->persist($questionnaire2);

        
        // Création d'un questionnaire
        $questionnaireInformatique = new Questionnaire();
        $questionnaireInformatique->setNomQuestionnaire('Questionnaire sur l\'informatique');
        $questionnaireInformatique->setTheme('Informatique');

        // Création de questions
        $question1 = new Question();
        $question2 = new Question();
        $question3 = new Question();

        // Création de réponses
        $reponse1 = new Reponse();
        $reponse1->setNomReponse('Vrai');
        $reponse1->setQuestion($question1);
        $reponse1->setEstCorrect(true);

        $reponse2 = new Reponse();
        $reponse2->setNomReponse('Faux');
        $reponse2->setQuestion($question1);
        $reponse2->setEstCorrect(false);

        $reponse3 = new Reponse();
        $reponse3->setNomReponse('Windows');
        $reponse3->setQuestion($question2);
        $reponse3->setEstCorrect(false);

        $reponse4 = new Reponse();
        $reponse4->setNomReponse('MacOS');
        $reponse4->setQuestion($question2);
        $reponse4->setEstCorrect(false);

        $reponse5 = new Reponse();
        $reponse5->setNomReponse('Linux');
        $reponse5->setQuestion($question2);
        $reponse5->setEstCorrect(true);

        $reponse6 = new Reponse();
        $reponse6->setNomReponse('Java');
        $reponse6->setQuestion($question3);
        $reponse6->setEstCorrect(false);

        $reponse7 = new Reponse();
        $reponse7->setNomReponse('Python');
        $reponse7->setQuestion($question3);
        $reponse7->setEstCorrect(true);

        $reponse8 = new Reponse();
        $reponse8->setNomReponse('C++');
        $reponse8->setQuestion($question3);
        $reponse8->setEstCorrect(false);

        $manager->persist($question1);
        $manager->persist($question2);
        $manager->persist($question3);
        $manager->persist($reponse1);
        $manager->persist($reponse2);
        $manager->persist($reponse3);
        $manager->persist($reponse4);
        $manager->persist($reponse5);
        $manager->persist($reponse6);
        $manager->persist($reponse7);
        $manager->persist($reponse8);

        // set des bonne(s) réponse(s) sur les questions
        $question1->setNomQuestion('Le langage PHP est-il un langage compilé ?');
        $question1->setQuestionnaire($questionnaireInformatique);
        $question1->setPointQuestion(0);
        $question1->setTypeQuestion("unique");

        $question2->setNomQuestion('Quel est le nom d\'un système d\'exploitation libre ?');
        $question2->setQuestionnaire($questionnaireInformatique);
        $question2->setPointQuestion(0);
        $question2->setTypeQuestion("multiple");

        $question3->setNomQuestion('Quel est le langage de programmation le plus utilisé au monde ?');
        $question3->setQuestionnaire($questionnaireInformatique);
        $question3->setPointQuestion(0);
        $question3->setTypeQuestion("unique");

        $manager->persist($questionnaireInformatique);
        $manager->flush();
    }
}
