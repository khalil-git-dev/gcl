<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210704144235 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE assister (id INT AUTO_INCREMENT NOT NULL, cours_id INT NOT NULL, eleve_id INT DEFAULT NULL, type VARCHAR(15) NOT NULL, minutes_retard DOUBLE PRECISION DEFAULT NULL, INDEX IDX_31849FA57ECF78B0 (cours_id), INDEX IDX_31849FA5A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE assister ADD CONSTRAINT FK_31849FA57ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE assister ADD CONSTRAINT FK_31849FA5A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('DROP TABLE cours_eleve');
        $this->addSql('ALTER TABLE materiel ADD nombre INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours_eleve (cours_id INT NOT NULL, eleve_id INT NOT NULL, INDEX IDX_DCC78C217ECF78B0 (cours_id), INDEX IDX_DCC78C21A6CC7B2 (eleve_id), PRIMARY KEY(cours_id, eleve_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cours_eleve ADD CONSTRAINT FK_DCC78C217ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_eleve ADD CONSTRAINT FK_DCC78C21A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE assister');
        $this->addSql('ALTER TABLE materiel DROP nombre');
    }
}
