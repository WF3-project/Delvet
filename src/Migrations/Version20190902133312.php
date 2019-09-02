<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190902133312 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE courses_user (courses_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_497364F7F9295384 (courses_id), INDEX IDX_497364F7A76ED395 (user_id), PRIMARY KEY(courses_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE courses_user ADD CONSTRAINT FK_497364F7F9295384 FOREIGN KEY (courses_id) REFERENCES courses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE courses_user ADD CONSTRAINT FK_497364F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user CHANGE role role JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE courses_user');
        $this->addSql('ALTER TABLE user CHANGE role role LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
