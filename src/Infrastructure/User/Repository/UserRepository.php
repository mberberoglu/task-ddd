<?php

namespace App\Infrastructure\User\Repository;

use App\Domain\User\Exception\UserNotFoundException;
use App\Domain\User\Model\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\ValueObject\Email;
use App\Domain\User\ValueObject\UserId;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Class UserRepository.
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function findOneByUsername(string $username): ?User
    {
        return $this->createQueryBuilder('user')
            ->where('user.auth.username = :username')
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByEmail(Email $email): ?User
    {
        return $this->createQueryBuilder('user')
            ->where('user.email = :email')
            ->setParameter('email', $email->toString())
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneByUuid(UserId $userId): ?User
    {
        return $this->createQueryBuilder('user')
            ->where('user.uuid = :id')
            ->setParameter('id', $userId)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getOneByUuid(UserId $userId): User
    {
        $user = $this->findOneByUuid($userId);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }
}
