<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180619150945 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE enseignant (id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, entreprise VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE matiere (id INTEGER NOT NULL, intitule VARCHAR(255) NOT NULL, description CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE matiere_enseignant (matiere_id INTEGER NOT NULL, enseignant_id INTEGER NOT NULL, PRIMARY KEY(matiere_id, enseignant_id))');
        $this->addSql('CREATE INDEX IDX_536FA40FF46CD258 ON matiere_enseignant (matiere_id)');
        $this->addSql('CREATE INDEX IDX_536FA40FE455FCC0 ON matiere_enseignant (enseignant_id)');
        $this->addSql('CREATE TABLE groupe (id INTEGER NOT NULL, promotion_id INTEGER DEFAULT NULL, nom VARCHAR(255) NOT NULL, description CLOB DEFAULT NULL, taille INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4B98C21139DF194 ON groupe (promotion_id)');
        $this->addSql('CREATE TABLE bac (id INTEGER NOT NULL, intitule VARCHAR(255) DEFAULT NULL, abreviation VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE csv (id INTEGER NOT NULL, promotion_id INTEGER DEFAULT NULL, csv_name VARCHAR(255) NOT NULL, csv_size INTEGER NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8A45257139DF194 ON csv (promotion_id)');
        $this->addSql('CREATE TABLE etudiant (id INTEGER NOT NULL, promotion_id INTEGER DEFAULT NULL, bac_id INTEGER DEFAULT NULL, code_nip VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, classement INTEGER DEFAULT NULL, username VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_717E22E3139DF194 ON etudiant (promotion_id)');
        $this->addSql('CREATE INDEX IDX_717E22E3E03F15C0 ON etudiant (bac_id)');
        $this->addSql('CREATE TABLE promotion (id INTEGER NOT NULL, annee_debut INTEGER NOT NULL, annee_fin INTEGER NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE enseignant');
        $this->addSql('DROP TABLE matiere');
        $this->addSql('DROP TABLE matiere_enseignant');
        $this->addSql('DROP TABLE groupe');
        $this->addSql('DROP TABLE bac');
        $this->addSql('DROP TABLE csv');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE promotion');
    }
}
