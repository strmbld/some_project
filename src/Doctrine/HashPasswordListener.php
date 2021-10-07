<?php

namespace App\Doctrine;

use App\Entity\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class HashPasswordListener implements EventSubscriber
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function getSubscribedEvents()
    {
        return ['prePersist', 'preUpdate'];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        }

        $encoded = $this->passwordHasher->hashPassword($entity, $entity->getPlainPassword());
        $entity->setPassword($encoded);

        if ($this->isAdmin($entity)) {
            $entity->setPlainPassword('Not available if ROLE_ADMIN');
        }
    }

    public function isAdmin(User $user): bool
    {
        return array_search('ROLE_ADMIN', $user->getRoles());
    }

    public function isAlreadyAdmin(User $user): bool
    {
        return array_search('ROLE_ADMIN', $user->getRoles())
            && $user->getPlainPassword() === 'Not available if ROLE_ADMIN';
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof User) {
            return;
        }

        // already ROLE_ADMIN case
        if ($this->isAlreadyAdmin($entity)) {
            throw new Exception('Trying to update/edit existing admin user');
        }

        $encoded = $this->passwordHasher->hashPassword($entity, $entity->getPlainPassword());

        $entity->setPassword($encoded);

        // new ROLE_ADMIN case
        if ($this->isAdmin($entity)) {
            $entity->setPlainPassword('Not available if ROLE_ADMIN');
        }

        $em = $args->getEntityManager();
        $meta = $em->getClassMetadata(get_class($entity));
        $em->getUnitOfWork()->recomputeSingleEntityChangeSet($meta, $entity);
    }
}
