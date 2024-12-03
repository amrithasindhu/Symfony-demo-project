<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241121053416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, post_id INT NOT NULL, text VARCHAR(500) NOT NULL, INDEX IDX_9474526C4B89032C (post_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id)');
        $this->addSql('ALTER TABLE userprofile CHANGE name name VARCHAR(255) NOT NULL, CHANGE bio bio VARCHAR(1024) NOT NULL, CHANGE website_url website_url VARCHAR(255) NOT NULL, CHANGE twitter_username twitter_username VARCHAR(255) NOT NULL, CHANGE company company VARCHAR(255) NOT NULL, CHANGE location location VARCHAR(255) NOT NULL, CHANGE date_of_birth date_of_birth DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C4B89032C');
        $this->addSql('DROP TABLE comment');
        $this->addSql('ALTER TABLE userprofile CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE bio bio VARCHAR(1024) DEFAULT NULL, CHANGE website_url website_url VARCHAR(255) DEFAULT NULL, CHANGE twitter_username twitter_username VARCHAR(255) DEFAULT NULL, CHANGE company company VARCHAR(255) DEFAULT NULL, CHANGE location location VARCHAR(255) DEFAULT NULL, CHANGE date_of_birth date_of_birth DATE DEFAULT NULL');
    }
}
