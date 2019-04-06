<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190406010018 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE configuration (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, dateformat VARCHAR(255) NOT NULL, background_image VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A5E2A5D7A76ED395 ON configuration (user_id)');
        $this->addSql('CREATE TABLE project_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, description CLOB NOT NULL, start DATETIME NOT NULL, "end" DATETIME DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_B1A47C2EA76ED395 ON project_history (user_id)');
        $this->addSql('CREATE TABLE project_samples (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, sampleindex VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, blurb CLOB DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, project_image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_8F8C5B12A76ED395 ON project_samples (user_id)');
        $this->addSql('CREATE TABLE profile (id INTEGER NOT NULL, title VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, background CLOB NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(180) NOT NULL, email VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649F85E0677 ON user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
        $this->addSql('CREATE TABLE proficiencies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, years INTEGER NOT NULL, percent INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_1386EAD6A76ED395 ON proficiencies (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE configuration');
        $this->addSql('DROP TABLE project_history');
        $this->addSql('DROP TABLE project_samples');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE proficiencies');
    }
}
