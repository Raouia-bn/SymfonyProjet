<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231223195034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, designation VARCHAR(30) NOT NULL, INDEX IDX_D8698A765200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evaluation (id INT AUTO_INCREMENT NOT NULL, examen_id INT NOT NULL, candidate_id INT NOT NULL, note INT NOT NULL, UNIQUE INDEX UNIQ_1323A5755C8659A (examen_id), UNIQUE INDEX UNIQ_1323A57591BD8781 (candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE examen (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, designation VARCHAR(30) NOT NULL, datecreation DATETIME NOT NULL, INDEX IDX_514C8FEC613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, nomf VARCHAR(30) NOT NULL, nbsessions INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formation_user2 (formation_id INT NOT NULL, user2_id INT NOT NULL, INDEX IDX_63D34A9A5200282E (formation_id), INDEX IDX_63D34A9A441B8B65 (user2_id), PRIMARY KEY(formation_id, user2_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscri_formation (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, candidate_id INT NOT NULL, etat VARCHAR(20) NOT NULL, nom_formation VARCHAR(30) NOT NULL, UNIQUE INDEX UNIQ_8F45EA96613FECDF (session_id), UNIQUE INDEX UNIQ_8F45EA9691BD8781 (candidate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE migration (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE motif_reclamation (id INT AUTO_INCREMENT NOT NULL, designation VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rate (id INT AUTO_INCREMENT NOT NULL, candidate_id INT NOT NULL, formation_id INT NOT NULL, rating INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_DFEC3F3991BD8781 (candidate_id), UNIQUE INDEX UNIQ_DFEC3F395200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation_cand_format (id INT AUTO_INCREMENT NOT NULL, motif_reclamation_id INT DEFAULT NULL, candidat_id INT DEFAULT NULL, formateur_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_FA25205F2211E980 (motif_reclamation_id), UNIQUE INDEX UNIQ_FA25205F8D0EB82 (candidat_id), UNIQUE INDEX UNIQ_FA25205F155D8F51 (formateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE seance (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, designation VARCHAR(30) NOT NULL, duree INT NOT NULL, INDEX IDX_DF7DFD0E613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, formation_id INT DEFAULT NULL, designation VARCHAR(30) NOT NULL, datedeb DATE NOT NULL, datefin DATE NOT NULL, INDEX IDX_D044D5D45200282E (formation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user2 (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, phonenumber INT NOT NULL, adress VARCHAR(100) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', UNIQUE INDEX UNIQ_1558D4EFE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, password VARCHAR(20) NOT NULL, phonenumber INT NOT NULL, email VARCHAR(50) NOT NULL, adress VARCHAR(100) NOT NULL, role VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A765200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A5755C8659A FOREIGN KEY (examen_id) REFERENCES examen (id)');
        $this->addSql('ALTER TABLE evaluation ADD CONSTRAINT FK_1323A57591BD8781 FOREIGN KEY (candidate_id) REFERENCES user2 (id)');
        $this->addSql('ALTER TABLE examen ADD CONSTRAINT FK_514C8FEC613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE formation_user2 ADD CONSTRAINT FK_63D34A9A5200282E FOREIGN KEY (formation_id) REFERENCES formation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE formation_user2 ADD CONSTRAINT FK_63D34A9A441B8B65 FOREIGN KEY (user2_id) REFERENCES user2 (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE inscri_formation ADD CONSTRAINT FK_8F45EA96613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE inscri_formation ADD CONSTRAINT FK_8F45EA9691BD8781 FOREIGN KEY (candidate_id) REFERENCES user2 (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F3991BD8781 FOREIGN KEY (candidate_id) REFERENCES user2 (id)');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F395200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
        $this->addSql('ALTER TABLE reclamation_cand_format ADD CONSTRAINT FK_FA25205F2211E980 FOREIGN KEY (motif_reclamation_id) REFERENCES motif_reclamation (id)');
        $this->addSql('ALTER TABLE reclamation_cand_format ADD CONSTRAINT FK_FA25205F8D0EB82 FOREIGN KEY (candidat_id) REFERENCES user2 (id)');
        $this->addSql('ALTER TABLE reclamation_cand_format ADD CONSTRAINT FK_FA25205F155D8F51 FOREIGN KEY (formateur_id) REFERENCES user2 (id)');
        $this->addSql('ALTER TABLE seance ADD CONSTRAINT FK_DF7DFD0E613FECDF FOREIGN KEY (session_id) REFERENCES session (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D45200282E FOREIGN KEY (formation_id) REFERENCES formation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A5755C8659A');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A765200282E');
        $this->addSql('ALTER TABLE formation_user2 DROP FOREIGN KEY FK_63D34A9A5200282E');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F395200282E');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D45200282E');
        $this->addSql('ALTER TABLE reclamation_cand_format DROP FOREIGN KEY FK_FA25205F2211E980');
        $this->addSql('ALTER TABLE examen DROP FOREIGN KEY FK_514C8FEC613FECDF');
        $this->addSql('ALTER TABLE inscri_formation DROP FOREIGN KEY FK_8F45EA96613FECDF');
        $this->addSql('ALTER TABLE seance DROP FOREIGN KEY FK_DF7DFD0E613FECDF');
        $this->addSql('ALTER TABLE evaluation DROP FOREIGN KEY FK_1323A57591BD8781');
        $this->addSql('ALTER TABLE formation_user2 DROP FOREIGN KEY FK_63D34A9A441B8B65');
        $this->addSql('ALTER TABLE inscri_formation DROP FOREIGN KEY FK_8F45EA9691BD8781');
        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F3991BD8781');
        $this->addSql('ALTER TABLE reclamation_cand_format DROP FOREIGN KEY FK_FA25205F8D0EB82');
        $this->addSql('ALTER TABLE reclamation_cand_format DROP FOREIGN KEY FK_FA25205F155D8F51');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE evaluation');
        $this->addSql('DROP TABLE examen');
        $this->addSql('DROP TABLE formation');
        $this->addSql('DROP TABLE formation_user2');
        $this->addSql('DROP TABLE inscri_formation');
        $this->addSql('DROP TABLE migration');
        $this->addSql('DROP TABLE motif_reclamation');
        $this->addSql('DROP TABLE rate');
        $this->addSql('DROP TABLE reclamation_cand_format');
        $this->addSql('DROP TABLE seance');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE user2');
        $this->addSql('DROP TABLE users');
    }
}
