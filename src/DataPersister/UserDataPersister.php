<?php

namespace App\DataPersister;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;


class UserDataPersister extends AbstractController implements DataPersisterInterface
{
    private $entityManager;
    private $userPasswordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->entityManager = $entityManager;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function supports($data): bool
    {
        // TODO: Implement supports() method.
        return $data instanceof User;
    }

    /**
     * @param User $data
     */
    public function persist($data)
    {
        $this->denyAccessUnlessGranted('POST_EDIT', $data); // voir les droit
        if (!$data->getId()) {
            if ($data->getPassword()) {
                $data->setPassword(
                    $this->userPasswordEncoder->encodePassword($data, $data->getPassword())
                );
                $data->eraseCredentials();
            }
        }

        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}