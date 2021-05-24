<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210518183229 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe ADD niveau_id INT NOT NULL');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('CREATE INDEX IDX_8F87BF96B3E9C81 ON classe (niveau_id)');
        $this->addSql('ALTER TABLE eleve ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_ECA105F7A76ED395 ON eleve (user_id)');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_ED767E4FA76ED395 ON formateur (user_id)');
        $this->addSql('ALTER TABLE intendant ADD adresse_int LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96B3E9C81');
        $this->addSql('DROP INDEX IDX_8F87BF96B3E9C81 ON classe');
        $this->addSql('ALTER TABLE classe DROP niveau_id');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7A76ED395');
        $this->addSql('DROP INDEX IDX_ECA105F7A76ED395 ON eleve');
        $this->addSql('ALTER TABLE eleve DROP user_id');
        $this->addSql('ALTER TABLE formateur DROP FOREIGN KEY FK_ED767E4FA76ED395');
        $this->addSql('DROP INDEX IDX_ED767E4FA76ED395 ON formateur');
        $this->addSql('ALTER TABLE intendant DROP adresse_int');
    }
}
