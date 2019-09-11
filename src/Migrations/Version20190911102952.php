<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190911102952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contributors (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_72D26262A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contributors ADD CONSTRAINT FK_72D26262A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courses ADD contributors_id INT DEFAULT NULL, CHANGE categories_id categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4C120460D1 FOREIGN KEY (contributors_id) REFERENCES contributors (id)');
        $this->addSql('CREATE INDEX IDX_A9A55A4C120460D1 ON courses (contributors_id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL, CHANGE reset_token reset_token VARCHAR(255) DEFAULT NULL, CHANGE enabled enabled TINYINT(1) DEFAULT NULL, CHANGE confirmation_token confirmation_token TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4C120460D1');
        $this->addSql('DROP TABLE contributors');
        $this->addSql('DROP INDEX IDX_A9A55A4C120460D1 ON courses');
        $this->addSql('ALTER TABLE courses DROP contributors_id, CHANGE categories_id categories_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin, CHANGE reset_token reset_token VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE enabled enabled TINYINT(1) DEFAULT \'NULL\', CHANGE confirmation_token confirmation_token TINYINT(1) DEFAULT \'NULL\'');
    }
}
