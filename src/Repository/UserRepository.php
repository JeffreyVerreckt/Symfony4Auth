<?php

namespace App\Repository;


use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * Class UserRepository
 * @package App\Repository
 */
final class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{

    /**
     * UserRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int $userId
     * @return User
     */
    public function findById(int $userId): User
    {
        /** @var User $user */
        $user = parent::find($userId);
        return $user;
    }

    /**
     * @param string $email
     * @return User
     */
    public function findOneByEmail(string $email): User
    {
        /** @var User $user */
        $user = $this->findOneBy(['email' => $email]);
        return $user;
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        return parent::findAll();
    }

    /**
     * @param User $user
     */
    public function save(User $user): void
    {
        $this->_em->persist($user);
        $this->_em->flush();
    }
}
