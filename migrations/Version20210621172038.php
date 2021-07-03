<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621172038 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite ADD montant DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE agent_soins ADD user_id INT NOT NULL, ADD type_agt VARCHAR(30) NOT NULL, ADD telephone_agt VARCHAR(15) NOT NULL, ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE agent_soins ADD CONSTRAINT FK_57CF342FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_57CF342FA76ED395 ON agent_soins (user_id)');
        $this->addSql('ALTER TABLE facture ADD numero_fac VARCHAR(15) NOT NULL, DROP quantite_fac, DROP pu_fac');
        $this->addSql('ALTER TABLE maintenancier ADD is_active TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE note ADD formateur_id INT NOT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14155D8F51 ON note (formateur_id)');
        $this->addSql('ALTER TABLE partenaire ADD nom_complet VARCHAR(255) NOT NULL, DROP nom_par, DROP prenom_par');
        $this->addSql('ALTER TABLE service_medicale ADD detail_smed VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activite DROP montant');
        $this->addSql('ALTER TABLE agent_soins DROP FOREIGN KEY FK_57CF342FA76ED395');
        $this->addSql('DROP INDEX IDX_57CF342FA76ED395 ON agent_soins');
        $this->addSql('ALTER TABLE agent_soins DROP user_id, DROP type_agt, DROP telephone_agt, DROP email');
        $this->addSql('ALTER TABLE facture ADD quantite_fac DOUBLE PRECISION DEFAULT NULL, ADD pu_fac DOUBLE PRECISION NOT NULL, DROP numero_fac');
        $this->addSql('ALTER TABLE maintenancier DROP is_active');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14155D8F51');
        $this->addSql('DROP INDEX IDX_CFBDFA14155D8F51 ON note');
        $this->addSql('ALTER TABLE note DROP formateur_id');
        $this->addSql('ALTER TABLE partenaire ADD nom_par VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD prenom_par VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP nom_complet');
        $this->addSql('ALTER TABLE service_medicale DROP detail_smed');
    }
}
