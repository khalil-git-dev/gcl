<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524164930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE censeur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, prenom_cen VARCHAR(50) NOT NULL, nom_cen VARCHAR(15) NOT NULL, telephone VARCHAR(15) NOT NULL, adresse LONGTEXT DEFAULT NULL, email VARCHAR(50) DEFAULT NULL, INDEX IDX_82DC45D9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intendant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, prenom_int VARCHAR(40) NOT NULL, nom_int VARCHAR(15) NOT NULL, telephone VARCHAR(15) NOT NULL, email_int VARCHAR(40) NOT NULL, adresse_int LONGTEXT DEFAULT NULL, INDEX IDX_E4F3006AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proviseur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, prenom_pro VARCHAR(40) NOT NULL, nom_pro VARCHAR(15) NOT NULL, telephone_pro VARCHAR(15) NOT NULL, email_pro VARCHAR(40) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, INDEX IDX_17AD1D60A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE censeur ADD CONSTRAINT FK_82DC45D9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE intendant ADD CONSTRAINT FK_E4F3006AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE proviseur ADD CONSTRAINT FK_17AD1D60A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classe ADD niveau_id INT NOT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('CREATE INDEX IDX_8F87BF96B3E9C81 ON classe (niveau_id)');
        $this->addSql('ALTER TABLE eleve ADD user_id INT DEFAULT NULL, ADD user_parent_id INT NOT NULL, CHANGE etat_ele etat_ele TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7729A4794 FOREIGN KEY (user_parent_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_ECA105F7A76ED395 ON eleve (user_id)');
        $this->addSql('CREATE INDEX IDX_ECA105F7729A4794 ON eleve (user_parent_id)');
        $this->addSql('ALTER TABLE formateur ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_ED767E4FA76ED395 ON formateur (user_id)');
        $this->addSql('ALTER TABLE inscription ADD status_ins VARCHAR(20) NOT NULL, ADD numero_ins VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE reglement ADD numero_reg VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE surveillant ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE surveillant ADD CONSTRAINT FK_960905BAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_960905BAA76ED395 ON surveillant (user_id)');
        $this->addSql('ALTER TABLE user DROP prenom, DROP nom, DROP telephone');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE censeur');
        $this->addSql('DROP TABLE intendant');
        $this->addSql('DROP TABLE proviseur');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96B3E9C81');
        $this->addSql('DROP INDEX IDX_8F87BF96B3E9C81 ON classe');
        $this->addSql('ALTER TABLE classe DROP niveau_id');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7A76ED395');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7729A4794');
        $this->addSql('DROP INDEX IDX_ECA105F7A76ED395 ON eleve');
        $this->addSql('DROP INDEX IDX_ECA105F7729A4794 ON eleve');
        $this->addSql('ALTER TABLE eleve DROP user_id, DROP user_parent_id, CHANGE etat_ele etat_ele VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE formateur DROP FOREIGN KEY FK_ED767E4FA76ED395');
        $this->addSql('DROP INDEX IDX_ED767E4FA76ED395 ON formateur');
        $this->addSql('ALTER TABLE formateur DROP user_id');
        $this->addSql('ALTER TABLE inscription DROP status_ins, DROP numero_ins');
        $this->addSql('ALTER TABLE reglement DROP numero_reg');
        $this->addSql('ALTER TABLE surveillant DROP FOREIGN KEY FK_960905BAA76ED395');
        $this->addSql('DROP INDEX IDX_960905BAA76ED395 ON surveillant');
        $this->addSql('ALTER TABLE surveillant DROP user_id');
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD nom VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD telephone VARCHAR(15) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
