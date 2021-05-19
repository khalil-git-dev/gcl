<?php

namespace App\DataFixtures;

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
    
        $supAdmin = new User();
        $supAdmin->setUsername('supadmin@gmail.com');
        // $supAdmin->setPrenom('khalil');
        // $supAdmin->setNom('diop');
        // $supAdmin->setTelephone('777911628');
        $supAdmin->setRole($role);
        $supAdmin->setPassword($this->encoderpass->encodePassword($supAdmin, "supadmin"));

        $manager->persist($supAdmin);
        $manager->flush();

    }
}

// class AppFixtures extends Fixture
// {
//     public function load(ObjectManager $manager)
//      {
//       $faker = Faker\Factory::create('fr_FR');
//           // on crée 4 auteurs avec noms et prénoms "aléatoires" en français
//           $auteurs = Array();
//           for ($i = 0; $i < 4; $i++) {
//               $auteurs[$i] = new Auteur();
//               $auteurs[$i]->setNom($faker->lastName);
//               $auteurs[$i]->setPrenom($faker->firstName);

//               $manager->persist($auteurs[$i]);
//           }
//       // nouvelle boucle pour créer des livres

//       $livres = Array();

//       for ($i = 0; $i < 12; $i++) {
//               $livres[$i] = new Livre();
//               $livres[$i]->setTitre($faker->sentence($nbWords = 6, $variableNbWords = true));
//               $livres[$i]->setAnnee($faker->numberBetween($min = 1900, $max = 2020));
//               $livres[$i]->setAuteur($auteurs[$i % 3]);

//               $manager->persist($livres[$i]);
//           }

//           $manager->flush();
//       }
//   }