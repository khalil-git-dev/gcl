<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622134150 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE cours_eleve');
        $this->addSql('ALTER TABLE agent_soins ADD user_id INT NOT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE agent_soins ADD CONSTRAINT FK_57CF342FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_57CF342FA76ED395 ON agent_soins (user_id)');
        $this->addSql('ALTER TABLE evaluation ADD semestre INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours_eleve (cours_id INT NOT NULL, eleve_id INT NOT NULL, INDEX IDX_DCC78C217ECF78B0 (cours_id), INDEX IDX_DCC78C21A6CC7B2 (eleve_id), PRIMARY KEY(cours_id, eleve_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE cours_eleve ADD CONSTRAINT FK_DCC78C217ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_eleve ADD CONSTRAINT FK_DCC78C21A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agent_soins DROP FOREIGN KEY FK_57CF342FA76ED395');
        $this->addSql('DROP INDEX IDX_57CF342FA76ED395 ON agent_soins');
        $this->addSql('ALTER TABLE agent_soins DROP user_id, DROP email');
        $this->addSql('ALTER TABLE evaluation DROP semestre');
    }
}
