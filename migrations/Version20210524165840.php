<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524165840 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE activite (id INT AUTO_INCREMENT NOT NULL, libelle_act VARCHAR(100) NOT NULL, nature_act VARCHAR(100) NOT NULL, type_act VARCHAR(75) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agent_bibliotheque (id INT AUTO_INCREMENT NOT NULL, bibliotheque_id INT NOT NULL, nom_agent_bib VARCHAR(50) NOT NULL, tel_agent_bib VARCHAR(15) NOT NULL, INDEX IDX_30DC5C864419DE7D (bibliotheque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE agent_soins (id INT AUTO_INCREMENT NOT NULL, service_med_id INT NOT NULL, nom_complet_agent VARCHAR(50) NOT NULL, INDEX IDX_57CF342F47F93C5A (service_med_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE apport (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, partenaire_id INT NOT NULL, type_app VARCHAR(50) NOT NULL, description_app VARCHAR(255) DEFAULT NULL, montant_app VARCHAR(15) NOT NULL, INDEX IDX_E96D1F43B897366B (date_id), INDEX IDX_E96D1F4398DE13AC (partenaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bibliotheque (id INT AUTO_INCREMENT NOT NULL, nom_biblio VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bulletin (id INT AUTO_INCREMENT NOT NULL, dossier_id INT NOT NULL, service_med_id INT DEFAULT NULL, eleve_id INT NOT NULL, libelle_bul VARCHAR(30) NOT NULL, type_bul VARCHAR(30) NOT NULL, categorie_bul VARCHAR(30) NOT NULL, detail_bul VARCHAR(255) DEFAULT NULL, INDEX IDX_2B7D8942611C0C56 (dossier_id), INDEX IDX_2B7D894247F93C5A (service_med_id), INDEX IDX_2B7D8942A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE censeur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, prenom_cen VARCHAR(50) NOT NULL, nom_cen VARCHAR(15) NOT NULL, telephone VARCHAR(15) NOT NULL, adresse LONGTEXT DEFAULT NULL, email VARCHAR(50) DEFAULT NULL, INDEX IDX_82DC45D9A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classe (id INT AUTO_INCREMENT NOT NULL, serie_id INT NOT NULL, niveau_id INT NOT NULL, libelle_cl VARCHAR(30) NOT NULL, description_cl VARCHAR(255) NOT NULL, nb_max_eleve INT NOT NULL, INDEX IDX_8F87BF96D94388BD (serie_id), INDEX IDX_8F87BF96B3E9C81 (niveau_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, discipline_id INT NOT NULL, salle_id INT NOT NULL, formateur_id INT NOT NULL, libelle_cr VARCHAR(30) NOT NULL, detail_cr VARCHAR(255) DEFAULT NULL, duree_cr DOUBLE PRECISION NOT NULL, INDEX IDX_FDCA8C9CA5522701 (discipline_id), INDEX IDX_FDCA8C9CDC304035 (salle_id), INDEX IDX_FDCA8C9C155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours_classe (cours_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_E007AEFE7ECF78B0 (cours_id), INDEX IDX_E007AEFE8F5EA509 (classe_id), PRIMARY KEY(cours_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE date (id INT AUTO_INCREMENT NOT NULL, date_debut DATE NOT NULL, date_fin DATE DEFAULT NULL, date_emmission DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, libelle_dis VARCHAR(30) NOT NULL, coef_dis INT NOT NULL, quantum_horaire INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, etagere_id INT NOT NULL, code_doc VARCHAR(30) NOT NULL, type_doc VARCHAR(100) NOT NULL, libelle_doc VARCHAR(255) NOT NULL, categorie_doc VARCHAR(50) NOT NULL, INDEX IDX_D8698A766588D180 (etagere_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier (id INT AUTO_INCREMENT NOT NULL, date_id INT DEFAULT NULL, eleve_id INT NOT NULL, libelle_dos VARCHAR(100) NOT NULL, type_dos VARCHAR(50) NOT NULL, detail_dos VARCHAR(255) DEFAULT NULL, INDEX IDX_3D48E037B897366B (date_id), INDEX IDX_3D48E037A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve (id INT AUTO_INCREMENT NOT NULL, niveau_id INT NOT NULL, classe_id INT NOT NULL, user_id INT DEFAULT NULL, user_parent_id INT NOT NULL, nom_ele VARCHAR(15) NOT NULL, prenom_ele VARCHAR(50) NOT NULL, date_naiss_ele DATE NOT NULL, lieu_naiss_ele VARCHAR(30) NOT NULL, sexe_ele VARCHAR(10) NOT NULL, tel_ele VARCHAR(15) DEFAULT NULL, adresse_ele VARCHAR(255) NOT NULL, religion_ele VARCHAR(15) DEFAULT NULL, nationalite_elev VARCHAR(30) NOT NULL, etat_ele TINYINT(1) NOT NULL, detail_ele VARCHAR(255) DEFAULT NULL, nom_complet_pere VARCHAR(100) NOT NULL, nom_complet_mere VARCHAR(100) NOT NULL, nom_complet_tuteur_leg VARCHAR(100) DEFAULT NULL, tel_pere VARCHAR(15) NOT NULL, tel_mere VARCHAR(15) DEFAULT NULL, tel_tuteur_leg VARCHAR(15) DEFAULT NULL, INDEX IDX_ECA105F7B3E9C81 (niveau_id), INDEX IDX_ECA105F78F5EA509 (classe_id), INDEX IDX_ECA105F7A76ED395 (user_id), INDEX IDX_ECA105F7729A4794 (user_parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE eleve_document (eleve_id INT NOT NULL, document_id INT NOT NULL, INDEX IDX_CC846C02A6CC7B2 (eleve_id), INDEX IDX_CC846C02C33F7837 (document_id), PRIMARY KEY(eleve_id, document_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etagere (id INT AUTO_INCREMENT NOT NULL, rayon_id INT NOT NULL, libelle_etag VARCHAR(50) NOT NULL, INDEX IDX_B83FE5C4D3202E52 (rayon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, discipline_id INT NOT NULL, libelle_eval VARCHAR(50) NOT NULL, detail_eval VARCHAR(255) DEFAULT NULL, INDEX IDX_1323A575B897366B (date_id), INDEX IDX_1323A575A5522701 (discipline_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_eleve (evaluation_id INT NOT NULL, eleve_id INT NOT NULL, INDEX IDX_29567806456C5646 (evaluation_id), INDEX IDX_29567806A6CC7B2 (eleve_id), PRIMARY KEY(evaluation_id, eleve_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation_note (evaluation_id INT NOT NULL, note_id INT NOT NULL, INDEX IDX_82FBB5AC456C5646 (evaluation_id), INDEX IDX_82FBB5AC26ED0855 (note_id), PRIMARY KEY(evaluation_id, note_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, type_even VARCHAR(50) NOT NULL, libelle_even VARCHAR(100) NOT NULL, description_even LONGTEXT DEFAULT NULL, INDEX IDX_B26681EB897366B (date_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, inscription_id INT NOT NULL, libelle_fac VARCHAR(50) NOT NULL, article_fac VARCHAR(150) NOT NULL, quantite_fac DOUBLE PRECISION DEFAULT NULL, pu_fac DOUBLE PRECISION NOT NULL, montant_fac DOUBLE PRECISION NOT NULL, type_fac VARCHAR(30) NOT NULL, INDEX IDX_FE866410B897366B (date_id), INDEX IDX_FE8664105DAC5993 (inscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formateur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, nom_for VARCHAR(15) NOT NULL, prenom_for VARCHAR(30) NOT NULL, email_for VARCHAR(30) NOT NULL, matieres VARCHAR(200) DEFAULT NULL, type_for VARCHAR(30) NOT NULL, tel_for VARCHAR(15) NOT NULL, INDEX IDX_ED767E4FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, date_id INT NOT NULL, dossier_id INT NOT NULL, libelle_ins VARCHAR(50) NOT NULL, redevance_ins DOUBLE PRECISION NOT NULL, categorie_ins VARCHAR(30) NOT NULL, type_ins VARCHAR(30) NOT NULL, detail_ins VARCHAR(255) DEFAULT NULL, status_ins VARCHAR(20) NOT NULL, numero_ins VARCHAR(20) NOT NULL, INDEX IDX_5E90F6D6B897366B (date_id), INDEX IDX_5E90F6D6611C0C56 (dossier_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription_activite (inscription_id INT NOT NULL, activite_id INT NOT NULL, INDEX IDX_11E02AB05DAC5993 (inscription_id), INDEX IDX_11E02AB09B0F88B1 (activite_id), PRIMARY KEY(inscription_id, activite_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intendant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, prenom_int VARCHAR(40) NOT NULL, nom_int VARCHAR(15) NOT NULL, telephone VARCHAR(15) NOT NULL, email_int VARCHAR(40) NOT NULL, adresse_int LONGTEXT DEFAULT NULL, INDEX IDX_E4F3006AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenancier (id INT AUTO_INCREMENT NOT NULL, nom_maint VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, type_main VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenancier_salle (maintenancier_id INT NOT NULL, salle_id INT NOT NULL, INDEX IDX_1839D42C2A32ABB9 (maintenancier_id), INDEX IDX_1839D42CDC304035 (salle_id), PRIMARY KEY(maintenancier_id, salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel (id INT AUTO_INCREMENT NOT NULL, type_mat VARCHAR(30) NOT NULL, libelle_mat VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE materiel_salle (materiel_id INT NOT NULL, salle_id INT NOT NULL, INDEX IDX_9C3ADCE816880AAF (materiel_id), INDEX IDX_9C3ADCE8DC304035 (salle_id), PRIMARY KEY(materiel_id, salle_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau (id INT AUTO_INCREMENT NOT NULL, libelle_niv VARCHAR(30) NOT NULL, detail_niv VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE note (id INT AUTO_INCREMENT NOT NULL, bulletin_id INT NOT NULL, valeur_not DOUBLE PRECISION NOT NULL, appreciation VARCHAR(50) DEFAULT NULL, proportionalite_not INT NOT NULL, INDEX IDX_CFBDFA14D1AAB236 (bulletin_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partenaire (id INT AUTO_INCREMENT NOT NULL, type_part VARCHAR(30) NOT NULL, nom_par VARCHAR(30) NOT NULL, prenom_par VARCHAR(50) NOT NULL, categorie_par VARCHAR(30) NOT NULL, adresse_par LONGTEXT DEFAULT NULL, tel_par VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE proviseur (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, prenom_pro VARCHAR(40) NOT NULL, nom_pro VARCHAR(15) NOT NULL, telephone_pro VARCHAR(15) NOT NULL, email_pro VARCHAR(40) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, INDEX IDX_17AD1D60A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rayon (id INT AUTO_INCREMENT NOT NULL, bibliotheque_id INT NOT NULL, titre_ray VARCHAR(50) NOT NULL, detail_ray VARCHAR(255) DEFAULT NULL, INDEX IDX_D5E5BC3C4419DE7D (bibliotheque_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recu (id INT AUTO_INCREMENT NOT NULL, reglement_id INT NOT NULL, eleve_id INT NOT NULL, libelle_rec VARCHAR(100) NOT NULL, montant_rec DOUBLE PRECISION NOT NULL, detail_rec VARCHAR(255) DEFAULT NULL, INDEX IDX_C0D103176A477111 (reglement_id), INDEX IDX_C0D10317A6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reglement (id INT AUTO_INCREMENT NOT NULL, facture_id INT NOT NULL, libelle_reg VARCHAR(50) NOT NULL, detail_reg VARCHAR(255) DEFAULT NULL, numero_reg VARCHAR(15) NOT NULL, INDEX IDX_EBE4C14C7F2DEE08 (facture_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(40) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE salle (id INT AUTO_INCREMENT NOT NULL, code_sal VARCHAR(30) NOT NULL, libelle_sal VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, libelle_ser VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_medicale (id INT AUTO_INCREMENT NOT NULL, libelle_ser_med VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveillant (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, type_sur VARCHAR(100) NOT NULL, nom_sur VARCHAR(30) NOT NULL, prenom_sur VARCHAR(30) NOT NULL, email_sur VARCHAR(30) NOT NULL, INDEX IDX_960905BAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE surveillant_classe (surveillant_id INT NOT NULL, classe_id INT NOT NULL, INDEX IDX_37470541AA23F281 (surveillant_id), INDEX IDX_374705418F5EA509 (classe_id), PRIMARY KEY(surveillant_id, classe_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, role_id INT NOT NULL, username VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, created_at DATE NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), INDEX IDX_8D93D649D60322AC (role_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent_bibliotheque ADD CONSTRAINT FK_30DC5C864419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
        $this->addSql('ALTER TABLE agent_soins ADD CONSTRAINT FK_57CF342F47F93C5A FOREIGN KEY (service_med_id) REFERENCES service_medicale (id)');
        $this->addSql('ALTER TABLE apport ADD CONSTRAINT FK_E96D1F43B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE apport ADD CONSTRAINT FK_E96D1F4398DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D894247F93C5A FOREIGN KEY (service_med_id) REFERENCES service_medicale (id)');
        $this->addSql('ALTER TABLE bulletin ADD CONSTRAINT FK_2B7D8942A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE censeur ADD CONSTRAINT FK_82DC45D9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE classe ADD CONSTRAINT FK_8F87BF96B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9C155D8F51 FOREIGN KEY (formateur_id) REFERENCES formateur (id)');
        $this->addSql('ALTER TABLE cours_classe ADD CONSTRAINT FK_E007AEFE7ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cours_classe ADD CONSTRAINT FK_E007AEFE8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A766588D180 FOREIGN KEY (etagere_id) REFERENCES etagere (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E037A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7B3E9C81 FOREIGN KEY (niveau_id) REFERENCES niveau (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F78F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE eleve ADD CONSTRAINT FK_ECA105F7729A4794 FOREIGN KEY (user_parent_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE eleve_document ADD CONSTRAINT FK_CC846C02A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE eleve_document ADD CONSTRAINT FK_CC846C02C33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etagere ADD CONSTRAINT FK_B83FE5C4D3202E52 FOREIGN KEY (rayon_id) REFERENCES rayon (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A575A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE evaluation_eleve ADD CONSTRAINT FK_29567806456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_eleve ADD CONSTRAINT FK_29567806A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_note ADD CONSTRAINT FK_82FBB5AC456C5646 FOREIGN KEY (evaluation_id) REFERENCES evaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evaluation_note ADD CONSTRAINT FK_82FBB5AC26ED0855 FOREIGN KEY (note_id) REFERENCES note (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EB897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE8664105DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id)');
        $this->addSql('ALTER TABLE formateur ADD CONSTRAINT FK_ED767E4FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6B897366B FOREIGN KEY (date_id) REFERENCES date (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('ALTER TABLE inscription_activite ADD CONSTRAINT FK_11E02AB05DAC5993 FOREIGN KEY (inscription_id) REFERENCES inscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscription_activite ADD CONSTRAINT FK_11E02AB09B0F88B1 FOREIGN KEY (activite_id) REFERENCES activite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intendant ADD CONSTRAINT FK_E4F3006AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE maintenancier_salle ADD CONSTRAINT FK_1839D42C2A32ABB9 FOREIGN KEY (maintenancier_id) REFERENCES maintenancier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenancier_salle ADD CONSTRAINT FK_1839D42CDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materiel_salle ADD CONSTRAINT FK_9C3ADCE816880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE materiel_salle ADD CONSTRAINT FK_9C3ADCE8DC304035 FOREIGN KEY (salle_id) REFERENCES salle (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14D1AAB236 FOREIGN KEY (bulletin_id) REFERENCES bulletin (id)');
        $this->addSql('ALTER TABLE proviseur ADD CONSTRAINT FK_17AD1D60A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE rayon ADD CONSTRAINT FK_D5E5BC3C4419DE7D FOREIGN KEY (bibliotheque_id) REFERENCES bibliotheque (id)');
        $this->addSql('ALTER TABLE recu ADD CONSTRAINT FK_C0D103176A477111 FOREIGN KEY (reglement_id) REFERENCES reglement (id)');
        $this->addSql('ALTER TABLE recu ADD CONSTRAINT FK_C0D10317A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES eleve (id)');
        $this->addSql('ALTER TABLE reglement ADD CONSTRAINT FK_EBE4C14C7F2DEE08 FOREIGN KEY (facture_id) REFERENCES facture (id)');
        $this->addSql('ALTER TABLE surveillant ADD CONSTRAINT FK_960905BAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE surveillant_classe ADD CONSTRAINT FK_37470541AA23F281 FOREIGN KEY (surveillant_id) REFERENCES surveillant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE surveillant_classe ADD CONSTRAINT FK_374705418F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D60322AC FOREIGN KEY (role_id) REFERENCES role (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription_activite DROP FOREIGN KEY FK_11E02AB09B0F88B1');
        $this->addSql('ALTER TABLE agent_bibliotheque DROP FOREIGN KEY FK_30DC5C864419DE7D');
        $this->addSql('ALTER TABLE rayon DROP FOREIGN KEY FK_D5E5BC3C4419DE7D');
        $this->addSql('ALTER TABLE note DROP FOREIGN KEY FK_CFBDFA14D1AAB236');
        $this->addSql('ALTER TABLE cours_classe DROP FOREIGN KEY FK_E007AEFE8F5EA509');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F78F5EA509');
        $this->addSql('ALTER TABLE surveillant_classe DROP FOREIGN KEY FK_374705418F5EA509');
        $this->addSql('ALTER TABLE cours_classe DROP FOREIGN KEY FK_E007AEFE7ECF78B0');
        $this->addSql('ALTER TABLE apport DROP FOREIGN KEY FK_E96D1F43B897366B');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037B897366B');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575B897366B');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EB897366B');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410B897366B');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6B897366B');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CA5522701');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A575A5522701');
        $this->addSql('ALTER TABLE eleve_document DROP FOREIGN KEY FK_CC846C02C33F7837');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942611C0C56');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6611C0C56');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D8942A6CC7B2');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E037A6CC7B2');
        $this->addSql('ALTER TABLE eleve_document DROP FOREIGN KEY FK_CC846C02A6CC7B2');
        $this->addSql('ALTER TABLE evaluation_eleve DROP FOREIGN KEY FK_29567806A6CC7B2');
        $this->addSql('ALTER TABLE recu DROP FOREIGN KEY FK_C0D10317A6CC7B2');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A766588D180');
        $this->addSql('ALTER TABLE evaluation_eleve DROP FOREIGN KEY FK_29567806456C5646');
        $this->addSql('ALTER TABLE evaluation_note DROP FOREIGN KEY FK_82FBB5AC456C5646');
        $this->addSql('ALTER TABLE reglement DROP FOREIGN KEY FK_EBE4C14C7F2DEE08');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9C155D8F51');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE8664105DAC5993');
        $this->addSql('ALTER TABLE inscription_activite DROP FOREIGN KEY FK_11E02AB05DAC5993');
        $this->addSql('ALTER TABLE maintenancier_salle DROP FOREIGN KEY FK_1839D42C2A32ABB9');
        $this->addSql('ALTER TABLE materiel_salle DROP FOREIGN KEY FK_9C3ADCE816880AAF');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96B3E9C81');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7B3E9C81');
        $this->addSql('ALTER TABLE evaluation_note DROP FOREIGN KEY FK_82FBB5AC26ED0855');
        $this->addSql('ALTER TABLE apport DROP FOREIGN KEY FK_E96D1F4398DE13AC');
        $this->addSql('ALTER TABLE etagere DROP FOREIGN KEY FK_B83FE5C4D3202E52');
        $this->addSql('ALTER TABLE recu DROP FOREIGN KEY FK_C0D103176A477111');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D60322AC');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CDC304035');
        $this->addSql('ALTER TABLE maintenancier_salle DROP FOREIGN KEY FK_1839D42CDC304035');
        $this->addSql('ALTER TABLE materiel_salle DROP FOREIGN KEY FK_9C3ADCE8DC304035');
        $this->addSql('ALTER TABLE classe DROP FOREIGN KEY FK_8F87BF96D94388BD');
        $this->addSql('ALTER TABLE agent_soins DROP FOREIGN KEY FK_57CF342F47F93C5A');
        $this->addSql('ALTER TABLE bulletin DROP FOREIGN KEY FK_2B7D894247F93C5A');
        $this->addSql('ALTER TABLE surveillant_classe DROP FOREIGN KEY FK_37470541AA23F281');
        $this->addSql('ALTER TABLE censeur DROP FOREIGN KEY FK_82DC45D9A76ED395');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7A76ED395');
        $this->addSql('ALTER TABLE eleve DROP FOREIGN KEY FK_ECA105F7729A4794');
        $this->addSql('ALTER TABLE formateur DROP FOREIGN KEY FK_ED767E4FA76ED395');
        $this->addSql('ALTER TABLE intendant DROP FOREIGN KEY FK_E4F3006AA76ED395');
        $this->addSql('ALTER TABLE proviseur DROP FOREIGN KEY FK_17AD1D60A76ED395');
        $this->addSql('ALTER TABLE surveillant DROP FOREIGN KEY FK_960905BAA76ED395');
        $this->addSql('DROP TABLE activite');
        $this->addSql('DROP TABLE agent_bibliotheque');
        $this->addSql('DROP TABLE agent_soins');
        $this->addSql('DROP TABLE apport');
        $this->addSql('DROP TABLE bibliotheque');
        $this->addSql('DROP TABLE bulletin');
        $this->addSql('DROP TABLE censeur');
        $this->addSql('DROP TABLE classe');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE cours_classe');
        $this->addSql('DROP TABLE date');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE dossier');
        $this->addSql('DROP TABLE eleve');
        $this->addSql('DROP TABLE eleve_document');
        $this->addSql('DROP TABLE etagere');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE evaluation_eleve');
        $this->addSql('DROP TABLE evaluation_note');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE formateur');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE inscription_activite');
        $this->addSql('DROP TABLE intendant');
        $this->addSql('DROP TABLE maintenancier');
        $this->addSql('DROP TABLE maintenancier_salle');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('DROP TABLE materiel_salle');
        $this->addSql('DROP TABLE niveau');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE partenaire');
        $this->addSql('DROP TABLE proviseur');
        $this->addSql('DROP TABLE rayon');
        $this->addSql('DROP TABLE recu');
        $this->addSql('DROP TABLE reglement');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE salle');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE service_medicale');
        $this->addSql('DROP TABLE surveillant');
        $this->addSql('DROP TABLE surveillant_classe');
        $this->addSql('DROP TABLE user');
    }
}
