<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use DateTime;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function addUser(array $userData): void
    {
        $user = new User();
        $user->setEmail($userData['email']);
        $user->setPassword($userData['password']);
        $user->setFirstname($userData['firstname']);
        $user->setLastname($userData['lastname']);
        $user->setBirthday(new DateTime($userData['birthday']));

        $entityManager = $this->getEntityManager();
        $entityManager->persist($user);
        $entityManager->flush();
    }

    public function findUserByEmailAndPwd(string $email, string $password): ?User
    {
        return $this->createQueryBuilder('u')
        ->where('u.email = :email')
        ->andWhere('u.password = :password') // ⚠️    
            ->setParameter('email', $email)
            ->setParameter('password', $password) // ⚠️ Assurez-vous de hacher les mots de passe en vrai projet !
            ->getQuery()
            ->getOneOrNullResult();
    }
    

}
