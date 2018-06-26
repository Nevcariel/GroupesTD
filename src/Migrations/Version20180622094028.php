<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180622094028 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE enseignant_matiere (enseignant_id INTEGER NOT NULL, matiere_id INTEGER NOT NULL, PRIMARY KEY(enseignant_id, matiere_id))');
        $this->addSql('CREATE INDEX IDX_33D1A024E455FCC0 ON enseignant_matiere (enseignant_id)');
        $this->addSql('CREATE INDEX IDX_33D1A024F46CD258 ON enseignant_matiere (matiere_id)');
        $this->addSql('DROP TABLE matiere_enseignant');
        $this->addSql('DROP INDEX IDX_4B98C21139DF194');
        $this->addSql('CREATE TEMPORARY TABLE __temp__groupe AS SELECT id, promotion_id, nom, description, taille FROM groupe');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('CREATE TABLE groupe (id INTEGER NOT NULL, promotion_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, description CLOB DEFAULT NULL COLLATE BINARY, taille INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_4B98C21139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO groupe (id, promotion_id, nom, description, taille) SELECT id, promotion_id, nom, description, taille FROM __temp__groupe');
        $this->addSql('DROP TABLE __temp__groupe');
        $this->addSql('CREATE INDEX IDX_4B98C21139DF194 ON groupe (promotion_id)');
        $this->addSql('DROP INDEX IDX_8A45257139DF194');
        $this->addSql('CREATE TEMPORARY TABLE __temp__csv AS SELECT id, promotion_id, file, name FROM csv');
        $this->addSql('DROP TABLE csv');
        $this->addSql('CREATE TABLE csv (id INTEGER NOT NULL, promotion_id INTEGER DEFAULT NULL, file VARCHAR(255) NOT NULL COLLATE BINARY, name VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_8A45257139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO csv (id, promotion_id, file, name) SELECT id, promotion_id, file, name FROM __temp__csv');
        $this->addSql('DROP TABLE __temp__csv');
        $this->addSql('CREATE INDEX IDX_8A45257139DF194 ON csv (promotion_id)');
        $this->addSql('DROP INDEX IDX_717E22E398F12918');
        $this->addSql('DROP INDEX IDX_717E22E3B0D610FE');
        $this->addSql('DROP INDEX IDX_717E22E37A45358C');
        $this->addSql('DROP INDEX IDX_717E22E3E03F15C0');
        $this->addSql('DROP INDEX IDX_717E22E3139DF194');
        $this->addSql('CREATE TEMPORARY TABLE __temp__etudiant AS SELECT id, promotion_id, bac_id, groupe_id, voeu_principal_id, voeu_secondaire_id, code_nip, nom, prenom, classement, username FROM etudiant');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('CREATE TABLE etudiant (id INTEGER NOT NULL, promotion_id INTEGER DEFAULT NULL, bac_id INTEGER DEFAULT NULL, groupe_id INTEGER DEFAULT NULL, voeu_principal_id INTEGER DEFAULT NULL, voeu_secondaire_id INTEGER DEFAULT NULL, code_nip VARCHAR(255) NOT NULL COLLATE BINARY, nom VARCHAR(255) NOT NULL COLLATE BINARY, prenom VARCHAR(255) NOT NULL COLLATE BINARY, classement INTEGER DEFAULT NULL, username VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_717E22E3139DF194 FOREIGN KEY (promotion_id) REFERENCES promotion (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_717E22E3E03F15C0 FOREIGN KEY (bac_id) REFERENCES bac (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_717E22E37A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_717E22E3B0D610FE FOREIGN KEY (voeu_principal_id) REFERENCES matiere (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_717E22E398F12918 FOREIGN KEY (voeu_secondaire_id) REFERENCES matiere (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO etudiant (id, promotion_id, bac_id, groupe_id, voeu_principal_id, voeu_secondaire_id, code_nip, nom, prenom, classement, username) SELECT id, promotion_id, bac_id, groupe_id, voeu_principal_id, voeu_secondaire_id, code_nip, nom, prenom, classement, username FROM __temp__etudiant');
        $this->addSql('DROP TABLE __temp__etudiant');
        $this->addSql('CREATE INDEX IDX_717E22E398F12918 ON etudiant (voeu_secondaire_id)');
        $this->addSql('CREATE INDEX IDX_717E22E3B0D610FE ON etudiant (voeu_principal_id)');
        $this->addSql('CREATE INDEX IDX_717E22E37A45358C ON etudiant (groupe_id)');
        $this->addSql('CREATE INDEX IDX_717E22E3E03F15C0 ON etudiant (bac_id)');
        $this->addSql('CREATE INDEX IDX_717E22E3139DF194 ON etudiant (promotion_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE matiere_enseignant (matiere_id INTEGER NOT NULL, enseignant_id INTEGER NOT NULL, PRIMARY KEY(matiere_id, enseignant_id))');
        $this->addSql('CREATE INDEX IDX_536FA40FE455FCC0 ON matiere_enseignant (enseignant_id)');
        $this->addSql('CREATE INDEX IDX_536FA40FF46CD258 ON matiere_enseignant (matiere_id)');
        $this->addSql('DROP TABLE enseignant_matiere');
        $this->addSql('DROP INDEX IDX_8A45257139DF194');
        $this->addSql('CREATE TEMPORARY TABLE __temp__csv AS SELECT id, promotion_id, file, name FROM csv');
        $this->addSql('DROP TABLE csv');
        $this->addSql('CREATE TABLE csv (id INTEGER NOT NULL, promotion_id INTEGER DEFAULT NULL, file VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO csv (id, promotion_id, file, name) SELECT id, promotion_id, file, name FROM __temp__csv');
        $this->addSql('DROP TABLE __temp__csv');
        $this->addSql('CREATE INDEX IDX_8A45257139DF194 ON csv (promotion_id)');
        $this->addSql('DROP INDEX IDX_717E22E3139DF194');
        $this->addSql('DROP INDEX IDX_717E22E3E03F15C0');
        $this->addSql('DROP INDEX IDX_717E22E37A45358C');
        $this->addSql('DROP INDEX IDX_717E22E3B0D610FE');
        $this->addSql('DROP INDEX IDX_717E22E398F12918');
        $this->addSql('CREATE TEMPORARY TABLE __temp__etudiant AS SELECT id, promotion_id, bac_id, groupe_id, voeu_principal_id, voeu_secondaire_id, code_nip, nom, prenom, classement, username FROM etudiant');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('CREATE TABLE etudiant (id INTEGER NOT NULL, promotion_id INTEGER DEFAULT NULL, bac_id INTEGER DEFAULT NULL, groupe_id INTEGER DEFAULT NULL, voeu_principal_id INTEGER DEFAULT NULL, voeu_secondaire_id INTEGER DEFAULT NULL, code_nip VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, classement INTEGER DEFAULT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO etudiant (id, promotion_id, bac_id, groupe_id, voeu_principal_id, voeu_secondaire_id, code_nip, nom, prenom, classement, username) SELECT id, promotion_id, bac_id, groupe_id, voeu_principal_id, voeu_secondaire_id, code_nip, nom, prenom, classement, username FROM __temp__etudiant');
        $this->addSql('DROP TABLE __temp__etudiant');
        $this->addSql('CREATE INDEX IDX_717E22E3139DF194 ON etudiant (promotion_id)');
        $this->addSql('CREATE INDEX IDX_717E22E3E03F15C0 ON etudiant (bac_id)');
        $this->addSql('CREATE INDEX IDX_717E22E37A45358C ON etudiant (groupe_id)');
        $this->addSql('CREATE INDEX IDX_717E22E3B0D610FE ON etudiant (voeu_principal_id)');
        $this->addSql('CREATE INDEX IDX_717E22E398F12918 ON etudiant (voeu_secondaire_id)');
        $this->addSql('DROP INDEX IDX_4B98C21139DF194');
        $this->addSql('CREATE TEMPORARY TABLE __temp__groupe AS SELECT id, promotion_id, nom, description, taille FROM groupe');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('CREATE TABLE groupe (id INTEGER NOT NULL, promotion_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, taille INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO groupe (id, promotion_id, nom, description, taille) SELECT id, promotion_id, nom, description, taille FROM __temp__groupe');
        $this->addSql('DROP TABLE __temp__groupe');
        $this->addSql('CREATE INDEX IDX_4B98C21139DF194 ON groupe (promotion_id)');
    }
}
