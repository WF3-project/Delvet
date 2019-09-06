<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190906092714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE courses DROP FOREIGN KEY FK_A9A55A4CA21214B7');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP INDEX IDX_A9A55A4CA21214B7 ON courses');
        $this->addSql('ALTER TABLE courses DROP categories_id, DROP number_view');
        $this->addSql('ALTER TABLE user ADD reset_token VARCHAR(255) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, slug VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, author VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, content LONGTEXT DEFAULT NULL COLLATE utf8mb4_unicode_ci, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE courses ADD categories_id INT DEFAULT NULL, ADD number_view INT NOT NULL');
        $this->addSql('ALTER TABLE courses ADD CONSTRAINT FK_A9A55A4CA21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id)');
        $this->addSql('CREATE INDEX IDX_A9A55A4CA21214B7 ON courses (categories_id)');
        $this->addSql('ALTER TABLE user DROP reset_token, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
