<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624101656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent_soins ADD CONSTRAINT FK_57CF342FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_57CF342FA76ED395 ON agent_soins (user_id)');
        $this->addSql('ALTER TABLE evaluation ADD type_evel VARCHAR(35) NOT NULL, ADD semestre INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent_soins DROP FOREIGN KEY FK_57CF342FA76ED395');
        $this->addSql('DROP INDEX IDX_57CF342FA76ED395 ON agent_soins');
        $this->addSql('ALTER TABLE evaluation DROP type_evel, DROP semestre');
    }
}
