<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210504000414 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent_soins (id INT AUTO_INCREMENT NOT NULL, service_med_id INT NOT NULL, nom_complet_agent VARCHAR(50) NOT NULL, INDEX IDX_57CF342F47F93C5A (service_med_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bulletin (id INT AUTO_INCREMENT NOT NULL, dossier_id INT NOT NULL, service_med_id INT DEFAULT NULL, eleve_id INT NOT NULL, libelle_bul VARCHAR(30) NOT NULL, type_bul VARCHAR(30) NOT NULL, categorie_bul VARCHAR(30) NOT NULL, detail_bul VARCHAR(255) DEFAULT NULL, INDEX IDX_2B7D8942611C0C56 (dossier_id), INDEX IDX_2B7D894247F93C5A (service_med_id), INDEX IDX_2B7D8942A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, serie_id INT NOT NULL, libelle_cl VARCHAR(30) NOT NULL, description_cl VARCHAR(255) NOT NULL, nb_max_eleve INT NOT NULL, INDEX IDX_8F87BF96D94388BD (serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, discipline_id INT NOT NULL, salle_id INT NOT NULL, formateur_id INT NOT NULL, libelle_cr VARCHAR(30) NOT NULL, detail_cr VARCHAR(255) DEFAULT NULL, INDEX IDX_FDCA8C9CA5522701 (discipline_id), INDEX IDX_FDCA8C9CDC304035 (salle_id), INDEX IDX_FDCA8C9C155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours_classe (cours_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_E007AEFE7ECF78B0 (cours_id), INDEX IDX_E007AEFE8F5EA509 (classe_id), PRIMARY KEY(cours_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier (id INT AUTO_INCREMENT NOT NULL, date_id INT DEFAULT NULL, eleve_id INT NOT NULL, libelle_dos VARCHAR(100) NOT NULL, type_dos VARCHAR(50) NOT NULL, detail_dos VARCHAR(255) DEFAULT NULL, INDEX IDX_3D48E037B897366B (date_id), INDEX IDX_3D48E037A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, niveau_id INT NOT NULL, classe_id INT NOT NULL, nom_ele VARCHAR(15) NOT NULL, prenom_ele VARCHAR(50) NOT NULL, date_naiss_ele DATE NOT NULL, lieu_naiss_ele VARCHAR(30) NOT NULL, sexe_ele VARCHAR(10) NOT NULL, tel_ele VARCHAR(15) DEFAULT NULL, adresse_ele VARCHAR(255) NOT NULL, religion_ele VARCHAR(15) DEFAULT NULL, nationalite_elev VARCHAR(30) NOT NULL, etat_ele VARCHAR(15) NOT NULL, detail_ele VARCHAR(255) DEFAULT NULL, nom_complet_pere VARCHAR(100) NOT NULL, nom_complet_mere VARCHAR(100) NOT NULL, nom_complet_tuteur_leg VARCHAR(100) DEFAULT NULL, tel_pere VARCHAR(15) NOT NULL, tel_mere VARCHAR(15) DEFAULT NULL, tel_tuteur_leg VARCHAR(15) DEFAULT NULL, INDEX IDX_ECA105F7B3E9C81 (niveau_id), INDEX IDX_ECA105F78F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve_document (eleve_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_CC846C02A6CC7B2 (eleve_id), INDEX IDX_CC846C02C33F7837 (document_id), PRIMARY KEY(eleve_id, document_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, discipline_id INT NOT NULL, libelle_eval VARCHAR(50) NOT NULL, detail_eval VARCHAR(255) DEFAULT NULL, INDEX IDX_1323A575B897366B (date_id), INDEX IDX_1323A575A5522701 (discipline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_eleve (evaluation_id INT NOT NULL, eleve_id INT NOT NULL, INDEX IDX_29567806456C5646 (evaluation_id), INDEX IDX_29567806A6CC7B2 (eleve_id), PRIMARY KEY(evaluation_id, eleve_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_note (evaluation_id INT NOT NULL, note_id INT NOT NULL, INDEX IDX_82FBB5AC456C5646 (evaluation_id), INDEX IDX_82FBB5AC26ED0855 (note_id), PRIMARY KEY(evaluation_id, note_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, inscription_id INT NOT NULL, libelle_fac VARCHAR(50) NOT NULL, article_fac VARCHAR(150) NOT NULL, quantite_fac DOUBLE PRECISION DEFAULT NULL, pu_fac DOUBLE PRECISION NOT NULL, montant_fac DOUBLE PRECISION NOT NULL, type_fac VARCHAR(30) NOT NULL, INDEX IDX_FE866410B897366B (date_id), INDEX IDX_FE8664105DAC5993 (inscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT AUTO_INCREMENT NOT NULL, nom_for VARCHAR(15) NOT NULL, prenom_for VARCHAR(30) NOT NULL, email_for VARCHAR(30) NOT NULL, matieres VARCHAR(200) DEFAULT NULL, type_for VARCHAR(30) NOT NULL, tel_for VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, dossier_id INT NOT NULL, libelle_ins VARCHAR(50) NOT NULL, redevance_ins DOUBLE PRECISION NOT NULL, categorie_ins VARCHAR(30) NOT NULL, type_ins VARCHAR(30) NOT NULL, detail_ins VARCHAR(255) DEFAULT NULL, INDEX IDX_5E90F6D6B897366B (date_id), INDEX IDX_5E90F6D6611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_activite (inscription_id INT NOT NULL, activite_id INT NOT NULL, INDEX IDX_11E02AB05DAC5993 (inscription_id), INDEX IDX_11E02AB09B0F88B1 (activite_id), PRIMARY KEY(inscription_id, activite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenancier_salle (maintenancier_id INT NOT NULL, salle_id INT NOT NULL, INDEX IDX_1839D42C2A32ABB9 (maintenancier_id), INDEX IDX_1839D42CDC304035 (salle_id), PRIMARY KEY(maintenancier_id, salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, type_mat VARCHAR(30) NOT NULL, libelle_mat VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel_salle (materiel_id INT NOT NULL, salle_id INT NOT NULL, INDEX IDX_9C3ADCE816880AAF (materiel_id), INDEX IDX_9C3ADCE8DC304035 (salle_id), PRIMARY KEY(materiel_id, salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, bulletin_id INT NOT NULL, valeur_not DOUBLE PRECISION NOT NULL, appreciation VARCHAR(50) DEFAULT NULL, proportionalite_not INT NOT NULL, INDEX IDX_CFBDFA14D1AAB236 (bulletin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recu (id INT AUTO_INCREMENT NOT NULL, reglement_id INT NOT NULL, eleve_id INT NOT NULL, libelle_rec VARCHAR(100) NOT NULL, montant_rec DOUBLE PRECISION NOT NULL, detail_rec VARCHAR(255) DEFAULT NULL, INDEX IDX_C0D103176A477111 (reglement_id), INDEX IDX_C0D10317A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reglement (id INT AUTO_INCREMENT NOT NULL, facture_id INT NOT NULL, libelle_reg VARCHAR(50) NOT NULL, detail_reg VARCHAR(255) DEFAULT NULL, INDEX IDX_EBE4C14C7F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, code_sal VARCHAR(30) NOT NULL, libelle_sal VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveillant_classe (surveillant_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_37470541AA23F281 (surveillant_id), INDEX IDX_374705418F5EA509 (classe_id), PRIMARY KEY(surveillant_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent_soins ADD CONSTRAINT FK_57CF342F47F93C5A FOREIGN KEY (service_med_id) REFERENCES service_medicale (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D894247F93C5A FOREIGN KEY (service_med_id) REFERENCES service_medicale (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE cours_classe ADD CONSTRAINT FK_E007AEFE7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_classe ADD CONSTRAINT FK_E007AEFE8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F78F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE eleve_document ADD CONSTRAINT FK_CC846C02A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleve_document ADD CONSTRAINT FK_CC846C02C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE evaluation_eleve ADD CONSTRAINT FK_29567806456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_eleve ADD CONSTRAINT FK_29567806A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_note ADD CONSTRAINT FK_82FBB5AC456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_note ADD CONSTRAINT FK_82FBB5AC26ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664105DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('ALTER TABLE inscription_activite ADD CONSTRAINT FK_11E02AB05DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_activite ADD CONSTRAINT FK_11E02AB09B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenancier_salle ADD CONSTRAINT FK_1839D42C2A32ABB9 FOREIGN KEY (maintenancier_id) REFERENCES maintenancier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenancier_salle ADD CONSTRAINT FK_1839D42CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materiel_salle ADD CONSTRAINT FK_9C3ADCE816880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materiel_salle ADD CONSTRAINT FK_9C3ADCE8DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14D1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id)');
        $this->addSql('ALTER TABLE recu ADD CONSTRAINT FK_C0D103176A477111 FOREIGN KEY (reglement_id) REFERENCES reglement (id)');
        $this->addSql('ALTER TABLE recu ADD CONSTRAINT FK_C0D10317A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE surveillant_classe ADD CONSTRAINT FK_37470541AA23F281 FOREIGN KEY (surveillant_id) REFERENCES surveillant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE surveillant_classe ADD CONSTRAINT FK_374705418F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
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
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6611C0C56');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942A6CC7B2');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037A6CC7B2');
        $this->addSql('ALTER TABLE eleve_document DROP FOREIGN KEY FK_CC846C02A6CC7B2');
        $this->addSql('ALTER TABLE evaluation_eleve DROP FOREIGN KEY FK_29567806A6CC7B2');
        $this->addSql('ALTER TABLE recu DROP FOREIGN KEY FK_C0D10317A6CC7B2');
        $this->addSql('ALTER TABLE evaluation_eleve DROP FOREIGN KEY FK_29567806456C5646');
        $this->addSql('ALTER TABLE evaluation_note DROP FOREIGN KEY FK_82FBB5AC456C5646');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C7F2DEE08');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C155D8F51');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664105DAC5993');
        $this->addSql('ALTER TABLE inscription_activite DROP FOREIGN KEY FK_11E02AB05DAC5993');
        $this->addSql('ALTER TABLE materiel_salle DROP FOREIGN KEY FK_9C3ADCE816880AAF');
        $this->addSql('ALTER TABLE evaluation_note DROP FOREIGN KEY FK_82FBB5AC26ED0855');
        $this->addSql('ALTER TABLE recu DROP FOREIGN KEY FK_C0D103176A477111');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CDC304035');
        $this->addSql('ALTER TABLE maintenancier_salle DROP FOREIGN KEY FK_1839D42CDC304035');
        $this->addSql('ALTER TABLE materiel_salle DROP FOREIGN KEY FK_9C3ADCE8DC304035');
        $this->addSql('DROP TABLE agent_soins');
        $this->addSql('DROP TABLE bulletin');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE cours_classe');
        $this->addSql('DROP TABLE dossier');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE eleve_document');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE evaluation_eleve');
        $this->addSql('DROP TABLE evaluation_note');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscription_activite');
        $this->addSql('DROP TABLE maintenancier_salle');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE materiel_salle');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE recu');
        $this->addSql('DROP TABLE reglement');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE surveillant_classe');
    }
}
