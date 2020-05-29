<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200529081815 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE modification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, work_team_id INT DEFAULT NULL, project_id INT DEFAULT NULL, project_status_id INT DEFAULT NULL, task_id INT DEFAULT NULL, task_status_id INT DEFAULT NULL, field VARCHAR(255) DEFAULT NULL, old_value LONGTEXT DEFAULT NULL, new_value LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_EF6425D2A76ED395 (user_id), INDEX IDX_EF6425D2FCA7608C (work_team_id), INDEX IDX_EF6425D2166D1F9C (project_id), INDEX IDX_EF6425D27ACB456A (project_status_id), INDEX IDX_EF6425D28DB60186 (task_id), INDEX IDX_EF6425D214DDCDEC (task_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, project_status_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_2FB3D0EE7ACB456A (project_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project_status (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, display_order SMALLINT DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, task_status_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, INDEX IDX_527EDB2514DDCDEC (task_status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_user (task_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_FE2042328DB60186 (task_id), INDEX IDX_FE204232A76ED395 (user_id), PRIMARY KEY(task_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_status (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_team (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, enabled TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE work_team_user (work_team_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_3E7A8A67FCA7608C (work_team_id), INDEX IDX_3E7A8A67A76ED395 (user_id), PRIMARY KEY(work_team_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE modification ADD CONSTRAINT FK_EF6425D2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE modification ADD CONSTRAINT FK_EF6425D2FCA7608C FOREIGN KEY (work_team_id) REFERENCES work_team (id)');
        $this->addSql('ALTER TABLE modification ADD CONSTRAINT FK_EF6425D2166D1F9C FOREIGN KEY (project_id) REFERENCES project (id)');
        $this->addSql('ALTER TABLE modification ADD CONSTRAINT FK_EF6425D27ACB456A FOREIGN KEY (project_status_id) REFERENCES project_status (id)');
        $this->addSql('ALTER TABLE modification ADD CONSTRAINT FK_EF6425D28DB60186 FOREIGN KEY (task_id) REFERENCES task (id)');
        $this->addSql('ALTER TABLE modification ADD CONSTRAINT FK_EF6425D214DDCDEC FOREIGN KEY (task_status_id) REFERENCES task_status (id)');
        $this->addSql('ALTER TABLE project ADD CONSTRAINT FK_2FB3D0EE7ACB456A FOREIGN KEY (project_status_id) REFERENCES project_status (id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB2514DDCDEC FOREIGN KEY (task_status_id) REFERENCES task_status (id)');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE2042328DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_user ADD CONSTRAINT FK_FE204232A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_team_user ADD CONSTRAINT FK_3E7A8A67FCA7608C FOREIGN KEY (work_team_id) REFERENCES work_team (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE work_team_user ADD CONSTRAINT FK_3E7A8A67A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE modification DROP FOREIGN KEY FK_EF6425D2166D1F9C');
        $this->addSql('ALTER TABLE modification DROP FOREIGN KEY FK_EF6425D27ACB456A');
        $this->addSql('ALTER TABLE project DROP FOREIGN KEY FK_2FB3D0EE7ACB456A');
        $this->addSql('ALTER TABLE modification DROP FOREIGN KEY FK_EF6425D28DB60186');
        $this->addSql('ALTER TABLE task_user DROP FOREIGN KEY FK_FE2042328DB60186');
        $this->addSql('ALTER TABLE modification DROP FOREIGN KEY FK_EF6425D214DDCDEC');
        $this->addSql('ALTER TABLE task DROP FOREIGN KEY FK_527EDB2514DDCDEC');
        $this->addSql('ALTER TABLE modification DROP FOREIGN KEY FK_EF6425D2A76ED395');
        $this->addSql('ALTER TABLE task_user DROP FOREIGN KEY FK_FE204232A76ED395');
        $this->addSql('ALTER TABLE work_team_user DROP FOREIGN KEY FK_3E7A8A67A76ED395');
        $this->addSql('ALTER TABLE modification DROP FOREIGN KEY FK_EF6425D2FCA7608C');
        $this->addSql('ALTER TABLE work_team_user DROP FOREIGN KEY FK_3E7A8A67FCA7608C');
        $this->addSql('DROP TABLE modification');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE project_status');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_user');
        $this->addSql('DROP TABLE task_status');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE work_team');
        $this->addSql('DROP TABLE work_team_user');
    }
}
