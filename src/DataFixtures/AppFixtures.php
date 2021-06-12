<?php

namespace App\DataFixtures;

use App\Entity\Proviseur;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class AppFixtures extends Fixture
{
    private $encoderpass;
    public function __construct(UserPasswordEncoderInterface $encoderpass)
    {
        $this->encoderpass = $encoderpass;
    }

    public function load(ObjectManager $manager)
    {
        $role = new Role();
        $role->setLibelle('SUP_ADMIN');
        $manager->persist($role);

        $role1 = new Role();
        $role1->setLibelle('PROVISEUR');
        $manager->persist($role1);

        $role2 = new Role();
        $role2->setLibelle('FORMATEUR');
        $manager->persist($role2);

        $role3 = new Role();
        $role3->setLibelle('USER');
        $manager->persist($role3);

        $role4 = new Role();
        $role4->setLibelle('CENSEUR');
        $manager->persist($role4);

        $role5 = new Role();
        $role5->setLibelle('INTENDANT');
        $manager->persist($role5);

        $role6 = new Role();
        $role6->setLibelle('SURVEILLENT');
        $manager->persist($role6);

        $role7 = new Role();
        $role7->setLibelle('SURVEILLENT-GENERAL');
        $manager->persist($role7);

        $role8 = new Role();
        $role8->setLibelle('PARENT');
        $manager->persist($role8);

        $role9 = new Role();
        $role9->setLibelle('AGENT-SOINS');
        $manager->persist($role9);
    
        $supAdmin = new User();
        $supAdmin->setUsername('supadmin@gmail.com');
        $supAdmin->setRole($role);
        $supAdmin->setPassword($this->encoderpass->encodePassword($supAdmin, "supadmin"));
        $manager->persist($supAdmin);

        $userProviseur = new User();
        $userProviseur->setUsername('proviseur@gmail.com');
        $userProviseur->setRole($role1);
        $userProviseur->setPassword($this->encoderpass->encodePassword($userProviseur, "proviseur"));
        $manager->persist($userProviseur);

        $proviseur = new Proviseur();
        $proviseur->setPrenomPro("Madame");
        $proviseur->setNomPro("preira");
        $proviseur->setTelephonePro("772819029");
        $proviseur->setAdresse("Kounoune");
        $proviseur->setEmailPro("fpreira2@gmail.com");
        $proviseur->setUser($userProviseur);
        $manager->persist($proviseur);

        $manager->flush();

    }
}