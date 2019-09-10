<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190910165156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE courses CHANGE categories_id categories_id INT DEFAULT NULL, CHANGE date_create date_create DATETIME NOT NULL, CHANGE image file_name VARCHAR(255) NOT NULL, CHANGE description content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE user ADD reset_token VARCHAR(255) DEFAULT NULL, ADD enabled TINYINT(1) DEFAULT NULL, ADD confirmation_token TINYINT(1) DEFAULT NULL, CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE courses CHANGE categories_id categories_id INT DEFAULT NULL, CHANGE date_create date_create DATE NOT NULL, CHANGE file_name image VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE content description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE user DROP reset_token, DROP enabled, DROP confirmation_token, CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
