<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190808033026 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_A5E2A5D7A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__configuration AS SELECT id, user_id, site_title, dateformat, background_image, site_logo, favicon_image, color FROM configuration');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('CREATE TABLE configuration (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, site_title VARCHAR(255) DEFAULT NULL COLLATE BINARY, dateformat VARCHAR(255) NOT NULL COLLATE BINARY, background_image VARCHAR(255) NOT NULL COLLATE BINARY, site_logo VARCHAR(255) DEFAULT NULL COLLATE BINARY, favicon_image VARCHAR(255) DEFAULT NULL COLLATE BINARY, color VARCHAR(255) NOT NULL COLLATE BINARY, PRIMARY KEY(id), CONSTRAINT FK_A5E2A5D7A76ED395 FOREIGN KEY (user_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO configuration (id, user_id, site_title, dateformat, background_image, site_logo, favicon_image, color) SELECT id, user_id, site_title, dateformat, background_image, site_logo, favicon_image, color FROM __temp__configuration');
        $this->addSql('DROP TABLE __temp__configuration');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A5E2A5D7A76ED395 ON configuration (user_id)');
        $this->addSql('DROP INDEX IDX_B1A47C2EA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_history AS SELECT id, user_id, title, position, description, skills, start, "end" FROM project_history');
        $this->addSql('DROP TABLE project_history');
        $this->addSql('CREATE TABLE project_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, position VARCHAR(255) DEFAULT NULL COLLATE BINARY, description VARCHAR(1024) NOT NULL COLLATE BINARY, skills VARCHAR(255) DEFAULT NULL COLLATE BINARY, start DATETIME NOT NULL, "end" DATETIME DEFAULT NULL, CONSTRAINT FK_B1A47C2EA76ED395 FOREIGN KEY (user_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO project_history (id, user_id, title, position, description, skills, start, "end") SELECT id, user_id, title, position, description, skills, start, "end" FROM __temp__project_history');
        $this->addSql('DROP TABLE __temp__project_history');
        $this->addSql('CREATE INDEX IDX_B1A47C2EA76ED395 ON project_history (user_id)');
        $this->addSql('DROP INDEX IDX_8F8C5B12A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_samples AS SELECT id, user_id, sampleindex, title, blurb, link, project_image FROM project_samples');
        $this->addSql('DROP TABLE project_samples');
        $this->addSql('CREATE TABLE project_samples (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, sampleindex VARCHAR(255) NOT NULL COLLATE BINARY, title VARCHAR(255) NOT NULL COLLATE BINARY, blurb VARCHAR(255) DEFAULT NULL COLLATE BINARY, link VARCHAR(255) DEFAULT NULL COLLATE BINARY, project_image VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_8F8C5B12A76ED395 FOREIGN KEY (user_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO project_samples (id, user_id, sampleindex, title, blurb, link, project_image) SELECT id, user_id, sampleindex, title, blurb, link, project_image FROM __temp__project_samples');
        $this->addSql('DROP TABLE __temp__project_samples');
        $this->addSql('CREATE INDEX IDX_8F8C5B12A76ED395 ON project_samples (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__profile AS SELECT id, title, first_name, last_name, email, phone, image, background, summary, location, linkedin, github, gitlab, stackoverflow FROM profile');
        $this->addSql('DROP TABLE profile');
        $this->addSql('CREATE TABLE profile (id INTEGER NOT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, first_name VARCHAR(255) NOT NULL COLLATE BINARY, last_name VARCHAR(255) NOT NULL COLLATE BINARY, email VARCHAR(255) NOT NULL COLLATE BINARY, phone VARCHAR(255) DEFAULT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, background CLOB NOT NULL COLLATE BINARY, summary VARCHAR(1024) DEFAULT NULL COLLATE BINARY, location VARCHAR(255) DEFAULT NULL COLLATE BINARY, linkedin VARCHAR(255) DEFAULT NULL COLLATE BINARY, github VARCHAR(255) DEFAULT NULL COLLATE BINARY, gitlab VARCHAR(255) DEFAULT NULL COLLATE BINARY, stackoverflow VARCHAR(255) DEFAULT NULL COLLATE BINARY, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO profile (id, title, first_name, last_name, email, phone, image, background, summary, location, linkedin, github, gitlab, stackoverflow) SELECT id, title, first_name, last_name, email, phone, image, background, summary, location, linkedin, github, gitlab, stackoverflow FROM __temp__profile');
        $this->addSql('DROP TABLE __temp__profile');
        $this->addSql('DROP INDEX UNIQ_EBE6B47A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cover_letter AS SELECT id, user_id, "to", letter FROM cover_letter');
        $this->addSql('DROP TABLE cover_letter');
        $this->addSql('CREATE TABLE cover_letter (id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, letter CLOB DEFAULT NULL COLLATE BINARY, addressee VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id), CONSTRAINT FK_EBE6B47A76ED395 FOREIGN KEY (user_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO cover_letter (id, user_id, addressee, letter) SELECT id, user_id, "to", letter FROM __temp__cover_letter');
        $this->addSql('DROP TABLE __temp__cover_letter');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EBE6B47A76ED395 ON cover_letter (user_id)');
        $this->addSql('DROP INDEX IDX_1386EAD6A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__proficiencies AS SELECT id, user_id, title, category, years, percent, icon FROM proficiencies');
        $this->addSql('DROP TABLE proficiencies');
        $this->addSql('CREATE TABLE proficiencies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL COLLATE BINARY, category VARCHAR(255) DEFAULT NULL COLLATE BINARY, years INTEGER NOT NULL, percent INTEGER NOT NULL, icon VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_1386EAD6A76ED395 FOREIGN KEY (user_id) REFERENCES profile (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO proficiencies (id, user_id, title, category, years, percent, icon) SELECT id, user_id, title, category, years, percent, icon FROM __temp__proficiencies');
        $this->addSql('DROP TABLE __temp__proficiencies');
        $this->addSql('CREATE INDEX IDX_1386EAD6A76ED395 ON proficiencies (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP INDEX UNIQ_A5E2A5D7A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__configuration AS SELECT id, user_id, site_title, dateformat, background_image, site_logo, favicon_image, color FROM configuration');
        $this->addSql('DROP TABLE configuration');
        $this->addSql('CREATE TABLE configuration (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, site_title VARCHAR(255) DEFAULT NULL, dateformat VARCHAR(255) NOT NULL, background_image VARCHAR(255) NOT NULL, site_logo VARCHAR(255) DEFAULT NULL, favicon_image VARCHAR(255) DEFAULT NULL, color VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO configuration (id, user_id, site_title, dateformat, background_image, site_logo, favicon_image, color) SELECT id, user_id, site_title, dateformat, background_image, site_logo, favicon_image, color FROM __temp__configuration');
        $this->addSql('DROP TABLE __temp__configuration');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A5E2A5D7A76ED395 ON configuration (user_id)');
        $this->addSql('DROP INDEX UNIQ_EBE6B47A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__cover_letter AS SELECT id, user_id, addressee, letter FROM cover_letter');
        $this->addSql('DROP TABLE cover_letter');
        $this->addSql('CREATE TABLE cover_letter (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, letter CLOB DEFAULT NULL, "to" VARCHAR(255) DEFAULT NULL COLLATE BINARY)');
        $this->addSql('INSERT INTO cover_letter (id, user_id, "to", letter) SELECT id, user_id, addressee, letter FROM __temp__cover_letter');
        $this->addSql('DROP TABLE __temp__cover_letter');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EBE6B47A76ED395 ON cover_letter (user_id)');
        $this->addSql('DROP INDEX IDX_1386EAD6A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__proficiencies AS SELECT id, user_id, title, category, years, percent, icon FROM proficiencies');
        $this->addSql('DROP TABLE proficiencies');
        $this->addSql('CREATE TABLE proficiencies (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, category VARCHAR(255) DEFAULT NULL, years INTEGER NOT NULL, percent INTEGER NOT NULL, icon VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO proficiencies (id, user_id, title, category, years, percent, icon) SELECT id, user_id, title, category, years, percent, icon FROM __temp__proficiencies');
        $this->addSql('DROP TABLE __temp__proficiencies');
        $this->addSql('CREATE INDEX IDX_1386EAD6A76ED395 ON proficiencies (user_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__profile AS SELECT id, title, first_name, last_name, email, phone, location, linkedin, github, gitlab, stackoverflow, image, background, summary FROM profile');
        $this->addSql('DROP TABLE profile');
        $this->addSql('CREATE TABLE profile (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, phone VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, linkedin VARCHAR(255) DEFAULT NULL, github VARCHAR(255) DEFAULT NULL, gitlab VARCHAR(255) DEFAULT NULL, stackoverflow VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, background CLOB NOT NULL, summary VARCHAR(1024) DEFAULT NULL)');
        $this->addSql('INSERT INTO profile (id, title, first_name, last_name, email, phone, location, linkedin, github, gitlab, stackoverflow, image, background, summary) SELECT id, title, first_name, last_name, email, phone, location, linkedin, github, gitlab, stackoverflow, image, background, summary FROM __temp__profile');
        $this->addSql('DROP TABLE __temp__profile');
        $this->addSql('DROP INDEX IDX_B1A47C2EA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_history AS SELECT id, user_id, title, position, description, skills, start, "end" FROM project_history');
        $this->addSql('DROP TABLE project_history');
        $this->addSql('CREATE TABLE project_history (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, position VARCHAR(255) DEFAULT NULL, description VARCHAR(1024) NOT NULL, skills VARCHAR(255) DEFAULT NULL, start DATETIME NOT NULL, "end" DATETIME DEFAULT NULL)');
        $this->addSql('INSERT INTO project_history (id, user_id, title, position, description, skills, start, "end") SELECT id, user_id, title, position, description, skills, start, "end" FROM __temp__project_history');
        $this->addSql('DROP TABLE __temp__project_history');
        $this->addSql('CREATE INDEX IDX_B1A47C2EA76ED395 ON project_history (user_id)');
        $this->addSql('DROP INDEX IDX_8F8C5B12A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__project_samples AS SELECT id, user_id, sampleindex, title, blurb, link, project_image FROM project_samples');
        $this->addSql('DROP TABLE project_samples');
        $this->addSql('CREATE TABLE project_samples (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER DEFAULT NULL, sampleindex VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, blurb VARCHAR(255) DEFAULT NULL, link VARCHAR(255) DEFAULT NULL, project_image VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO project_samples (id, user_id, sampleindex, title, blurb, link, project_image) SELECT id, user_id, sampleindex, title, blurb, link, project_image FROM __temp__project_samples');
        $this->addSql('DROP TABLE __temp__project_samples');
        $this->addSql('CREATE INDEX IDX_8F8C5B12A76ED395 ON project_samples (user_id)');
    }
}
