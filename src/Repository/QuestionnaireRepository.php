<?php

namespace App\Repository;

use App\Entity\Questionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Questionnaire>
 *
 * @method Questionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Questionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Questionnaire[]    findAll()
 * @method Questionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class QuestionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Questionnaire::class);
    }

    public function save(Questionnaire $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Questionnaire $questionnaire, bool $flush = false): void
{
    $entityManager = $this->getEntityManager();

    // Delete related questions and answers
    $questions = $questionnaire->getQuestions();
    foreach ($questions as $question) {

        // Then, delete the other answers
        $answers = $question->getReponses();
        foreach ($answers as $answer) {
            $entityManager->remove($answer);
        }
    }
    $entityManager->flush(); // Flush changes after deleting answers

    foreach ($questions as $question) {
        $entityManager->remove($question);
    }
    $entityManager->flush(); // Flush changes after deleting questions

    // Finally, delete the questionnaire
    $entityManager->remove($questionnaire);

    if ($flush) {
        $entityManager->flush();
    }
}






//    /**
//     * @return Questionnaire[] Returns an array of Questionnaire objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('q.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Questionnaire
//    {
//        return $this->createQueryBuilder('q')
//            ->andWhere('q.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
