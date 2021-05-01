<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210429174435 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, libelle_act VARCHAR(100) NOT NULL, nature_act VARCHAR(100) NOT NULL, type_act VARCHAR(75) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bibliotheque (id INT AUTO_INCREMENT NOT NULL, nom_biblio VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, date_debut DATE NOT NULL, date_fin DATE DEFAULT NULL, date_emmission DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, libelle_dis VARCHAR(30) NOT NULL, coef_dis INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenancier (id INT AUTO_INCREMENT NOT NULL, nom_maint VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, type_main VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, libelle_niv VARCHAR(30) NOT NULL, detail_niv VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, type_part VARCHAR(30) NOT NULL, nom_par VARCHAR(30) NOT NULL, prenom_par VARCHAR(50) NOT NULL, categorie_par VARCHAR(30) NOT NULL, adresse_par LONGTEXT DEFAULT NULL, tel_par VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, libelle_ser VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_medicale (id INT AUTO_INCREMENT NOT NULL, libelle_ser_med VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveillant (id INT AUTO_INCREMENT NOT NULL, type_sur VARCHAR(100) NOT NULL, nom_sur VARCHAR(30) NOT NULL, prenom_sur VARCHAR(30) NOT NULL, email_sur VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE bibliotheque');
        $this->addSql('DROP TABLE date');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE maintenancier');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE service_medicale');
        $this->addSql('DROP TABLE surveillant');
    }
}
