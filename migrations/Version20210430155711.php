<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430155711 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent_bibliotheque (id INT AUTO_INCREMENT NOT NULL, bibliotheque_id INT NOT NULL, nom_agent_bib VARCHAR(50) NOT NULL, tel_agent_bib VARCHAR(15) NOT NULL, INDEX IDX_30DC5C864419DE7D (bibliotheque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apport (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, partenaire_id INT NOT NULL, type_app VARCHAR(50) NOT NULL, description_app VARCHAR(255) DEFAULT NULL, montant_app VARCHAR(15) NOT NULL, INDEX IDX_E96D1F43B897366B (date_id), INDEX IDX_E96D1F4398DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, etagere_id INT NOT NULL, code_doc VARCHAR(30) NOT NULL, type_doc VARCHAR(100) NOT NULL, libelle_doc VARCHAR(255) NOT NULL, categorie_doc VARCHAR(50) NOT NULL, INDEX IDX_D8698A766588D180 (etagere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etagere (id INT AUTO_INCREMENT NOT NULL, rayon_id INT NOT NULL, libelle_etag VARCHAR(50) NOT NULL, INDEX IDX_B83FE5C4D3202E52 (rayon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, type_even VARCHAR(50) NOT NULL, libelle_even VARCHAR(100) NOT NULL, description_even LONGTEXT DEFAULT NULL, INDEX IDX_B26681EB897366B (date_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rayon (id INT AUTO_INCREMENT NOT NULL, bibliotheque_id INT NOT NULL, titre_ray VARCHAR(50) NOT NULL, detail_ray VARCHAR(255) DEFAULT NULL, INDEX IDX_D5E5BC3C4419DE7D (bibliotheque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent_bibliotheque ADD CONSTRAINT FK_30DC5C864419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
        $this->addSql('ALTER TABLE apport ADD CONSTRAINT FK_E96D1F43B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE apport ADD CONSTRAINT FK_E96D1F4398DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A766588D180 FOREIGN KEY (etagere_id) REFERENCES etagere (id)');
        $this->addSql('ALTER TABLE etagere ADD CONSTRAINT FK_B83FE5C4D3202E52 FOREIGN KEY (rayon_id) REFERENCES rayon (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EB897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE rayon ADD CONSTRAINT FK_D5E5BC3C4419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
        $this->addSql('ALTER TABLE user ADD created_at DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A766588D180');
        $this->addSql('ALTER TABLE etagere DROP FOREIGN KEY FK_B83FE5C4D3202E52');
        $this->addSql('DROP TABLE agent_bibliotheque');
        $this->addSql('DROP TABLE apport');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE etagere');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE rayon');
        $this->addSql('ALTER TABLE user DROP created_at');
    }
}
