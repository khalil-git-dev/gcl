<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210430183848 extends AbstractMigration
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
        $this->addSql('CREATE TABLE bulletin (id INT AUTO_INCREMENT NOT NULL, dossier_id INT NOT NULL, libelle_bul VARCHAR(30) NOT NULL, type_bul VARCHAR(30) NOT NULL, categorie_bul VARCHAR(30) NOT NULL, detail_bul VARCHAR(255) DEFAULT NULL, INDEX IDX_2B7D8942611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, serie_id INT NOT NULL, libelle_cl VARCHAR(30) NOT NULL, description_cl VARCHAR(255) NOT NULL, nb_max_eleve INT NOT NULL, INDEX IDX_8F87BF96D94388BD (serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, discipline_id INT NOT NULL, salle_id INT NOT NULL, formateur_id INT NOT NULL, libelle_cr VARCHAR(30) NOT NULL, detail_cr VARCHAR(255) DEFAULT NULL, INDEX IDX_FDCA8C9CA5522701 (discipline_id), INDEX IDX_FDCA8C9CDC304035 (salle_id), INDEX IDX_FDCA8C9C155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours_classe (cours_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_E007AEFE7ECF78B0 (cours_id), INDEX IDX_E007AEFE8F5EA509 (classe_id), PRIMARY KEY(cours_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, etagere_id INT NOT NULL, code_doc VARCHAR(30) NOT NULL, type_doc VARCHAR(100) NOT NULL, libelle_doc VARCHAR(255) NOT NULL, categorie_doc VARCHAR(50) NOT NULL, INDEX IDX_D8698A766588D180 (etagere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier (id INT AUTO_INCREMENT NOT NULL, date_id INT DEFAULT NULL, libelle_dos VARCHAR(100) NOT NULL, type_dos VARCHAR(50) NOT NULL, detail_dos VARCHAR(255) DEFAULT NULL, INDEX IDX_3D48E037B897366B (date_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, niveau_id INT NOT NULL, classe_id INT NOT NULL, nom_ele VARCHAR(15) NOT NULL, prenom_ele VARCHAR(50) NOT NULL, date_naiss_ele DATE NOT NULL, lieu_naiss_ele VARCHAR(30) NOT NULL, sexe_ele VARCHAR(10) NOT NULL, tel_ele VARCHAR(15) DEFAULT NULL, adresse_ele VARCHAR(255) NOT NULL, religion_ele VARCHAR(15) DEFAULT NULL, nationalite_elev VARCHAR(30) NOT NULL, etat_ele VARCHAR(15) NOT NULL, detail_ele VARCHAR(255) DEFAULT NULL, nom_complet_pere VARCHAR(100) NOT NULL, nom_complet_mere VARCHAR(100) NOT NULL, nom_complet_tuteur_leg VARCHAR(100) DEFAULT NULL, tel_pere VARCHAR(15) NOT NULL, tel_mere VARCHAR(15) DEFAULT NULL, tel_tuteur_leg VARCHAR(15) DEFAULT NULL, INDEX IDX_ECA105F7B3E9C81 (niveau_id), INDEX IDX_ECA105F78F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etagere (id INT AUTO_INCREMENT NOT NULL, rayon_id INT NOT NULL, libelle_etag VARCHAR(50) NOT NULL, INDEX IDX_B83FE5C4D3202E52 (rayon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, discipline_id INT NOT NULL, libelle_eval VARCHAR(50) NOT NULL, detail_eval VARCHAR(255) DEFAULT NULL, INDEX IDX_1323A575B897366B (date_id), INDEX IDX_1323A575A5522701 (discipline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_eleve (evaluation_id INT NOT NULL, eleve_id INT NOT NULL, INDEX IDX_29567806456C5646 (evaluation_id), INDEX IDX_29567806A6CC7B2 (eleve_id), PRIMARY KEY(evaluation_id, eleve_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, type_even VARCHAR(50) NOT NULL, libelle_even VARCHAR(100) NOT NULL, description_even LONGTEXT DEFAULT NULL, INDEX IDX_B26681EB897366B (date_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT AUTO_INCREMENT NOT NULL, nom_for VARCHAR(15) NOT NULL, prenom_for VARCHAR(30) NOT NULL, email_for VARCHAR(30) NOT NULL, matieres VARCHAR(200) DEFAULT NULL, type_for VARCHAR(30) NOT NULL, tel_for VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenancier_salle (maintenancier_id INT NOT NULL, salle_id INT NOT NULL, INDEX IDX_1839D42C2A32ABB9 (maintenancier_id), INDEX IDX_1839D42CDC304035 (salle_id), PRIMARY KEY(maintenancier_id, salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, type_mat VARCHAR(30) NOT NULL, libelle_mat VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel_salle (materiel_id INT NOT NULL, salle_id INT NOT NULL, INDEX IDX_9C3ADCE816880AAF (materiel_id), INDEX IDX_9C3ADCE8DC304035 (salle_id), PRIMARY KEY(materiel_id, salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, bulletin_id INT NOT NULL, valeur_not DOUBLE PRECISION NOT NULL, appreciation VARCHAR(50) DEFAULT NULL, proportionalite_not INT NOT NULL, INDEX IDX_CFBDFA14D1AAB236 (bulletin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rayon (id INT AUTO_INCREMENT NOT NULL, bibliotheque_id INT NOT NULL, titre_ray VARCHAR(50) NOT NULL, detail_ray VARCHAR(255) DEFAULT NULL, INDEX IDX_D5E5BC3C4419DE7D (bibliotheque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, code_sal VARCHAR(30) NOT NULL, libelle_sal VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveillant_classe (surveillant_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_37470541AA23F281 (surveillant_id), INDEX IDX_374705418F5EA509 (classe_id), PRIMARY KEY(surveillant_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent_bibliotheque ADD CONSTRAINT FK_30DC5C864419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
        $this->addSql('ALTER TABLE apport ADD CONSTRAINT FK_E96D1F43B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE apport ADD CONSTRAINT FK_E96D1F4398DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE cours_classe ADD CONSTRAINT FK_E007AEFE7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_classe ADD CONSTRAINT FK_E007AEFE8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A766588D180 FOREIGN KEY (etagere_id) REFERENCES etagere (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F78F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE etagere ADD CONSTRAINT FK_B83FE5C4D3202E52 FOREIGN KEY (rayon_id) REFERENCES rayon (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE evaluation_eleve ADD CONSTRAINT FK_29567806456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_eleve ADD CONSTRAINT FK_29567806A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EB897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE maintenancier_salle ADD CONSTRAINT FK_1839D42C2A32ABB9 FOREIGN KEY (maintenancier_id) REFERENCES maintenancier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenancier_salle ADD CONSTRAINT FK_1839D42CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materiel_salle ADD CONSTRAINT FK_9C3ADCE816880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materiel_salle ADD CONSTRAINT FK_9C3ADCE8DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14D1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id)');
        $this->addSql('ALTER TABLE rayon ADD CONSTRAINT FK_D5E5BC3C4419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
        $this->addSql('ALTER TABLE surveillant_classe ADD CONSTRAINT FK_37470541AA23F281 FOREIGN KEY (surveillant_id) REFERENCES surveillant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE surveillant_classe ADD CONSTRAINT FK_374705418F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD created_at DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14D1AAB236');
        $this->addSql('ALTER TABLE cours_classe DROP FOREIGN KEY FK_E007AEFE8F5EA509');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F78F5EA509');
        $this->addSql('ALTER TABLE surveillant_classe DROP FOREIGN KEY FK_374705418F5EA509');
        $this->addSql('ALTER TABLE cours_classe DROP FOREIGN KEY FK_E007AEFE7ECF78B0');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942611C0C56');
        $this->addSql('ALTER TABLE evaluation_eleve DROP FOREIGN KEY FK_29567806A6CC7B2');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A766588D180');
        $this->addSql('ALTER TABLE evaluation_eleve DROP FOREIGN KEY FK_29567806456C5646');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C155D8F51');
        $this->addSql('ALTER TABLE materiel_salle DROP FOREIGN KEY FK_9C3ADCE816880AAF');
        $this->addSql('ALTER TABLE etagere DROP FOREIGN KEY FK_B83FE5C4D3202E52');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CDC304035');
        $this->addSql('ALTER TABLE maintenancier_salle DROP FOREIGN KEY FK_1839D42CDC304035');
        $this->addSql('ALTER TABLE materiel_salle DROP FOREIGN KEY FK_9C3ADCE8DC304035');
        $this->addSql('DROP TABLE agent_bibliotheque');
        $this->addSql('DROP TABLE apport');
        $this->addSql('DROP TABLE bulletin');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE cours_classe');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE dossier');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE etagere');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE evaluation_eleve');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE maintenancier_salle');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE materiel_salle');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE rayon');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE surveillant_classe');
        $this->addSql('ALTER TABLE user DROP created_at');
    }
}
