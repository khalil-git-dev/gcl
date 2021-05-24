<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        $role4->setLibelle('SURVEILLANT');
        $manager->persist($role4);

        $role5 = new Role();
        $role5->setLibelle('INTENDANT');
        $manager->persist($role5);

        $role6 = new Role();
        $role6->setLibelle('CENSEUR');
        $manager->persist($role6);
        
        $supAdmin = new User();
        $supAdmin->setUsername('supadmin@gmail.com');
        $supAdmin->setRole($role);
        $supAdmin->setPassword($this->encoderpass->encodePassword($supAdmin, "supadmin"));

        $manager->persist($supAdmin);
        $manager->flush();

    }
}
