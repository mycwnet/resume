<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190320035509 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE configuration CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE project_history CHANGE user_id user_id INT DEFAULT NULL, CHANGE end end DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE project_samples CHANGE user_id user_id INT DEFAULT NULL, CHANGE title title VARCHAR(255) DEFAULT NULL, CHANGE link link VARCHAR(255) DEFAULT NULL, CHANGE project_image project_image VARCHAR(255) DEFAULT NULL, CHANGE sample_index sample_index VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE profile CHANGE phone phone VARCHAR(255) DEFAULT NULL, CHANGE image image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE proficiencies CHANGE user_id user_id INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE configuration CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE proficiencies CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE profile CHANGE phone phone VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE image image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE project_history CHANGE user_id user_id INT DEFAULT NULL, CHANGE end end DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE project_samples CHANGE user_id user_id INT DEFAULT NULL, CHANGE sample_index sample_index VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE title title VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE link link VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE project_image project_image VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
