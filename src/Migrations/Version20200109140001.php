<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200109140001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE authors CHANGE link link VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED30F675F31B FOREIGN KEY (author_id) REFERENCES authors (id)');
        $this->addSql('ALTER TABLE movies RENAME INDEX author_id TO IDX_C61EED30F675F31B');
        $this->addSql('ALTER TABLE movies_has_categories ADD PRIMARY KEY (movie_id, category_id)');
        $this->addSql('ALTER TABLE movies_has_categories ADD CONSTRAINT FK_854384AF8F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id)');
        $this->addSql('ALTER TABLE movies_has_categories ADD CONSTRAINT FK_854384AF12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE movies_has_categories RENAME INDEX movie_id TO IDX_854384AF8F93B6FC');
        $this->addSql('ALTER TABLE movies_has_categories RENAME INDEX category_id TO IDX_854384AF12469DE2');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE authors CHANGE link link VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_unicode_ci`');
        $this->addSql('ALTER TABLE movies DROP FOREIGN KEY FK_C61EED30F675F31B');
        $this->addSql('ALTER TABLE movies RENAME INDEX idx_c61eed30f675f31b TO author_id');
        $this->addSql('ALTER TABLE movies_has_categories DROP FOREIGN KEY FK_854384AF8F93B6FC');
        $this->addSql('ALTER TABLE movies_has_categories DROP FOREIGN KEY FK_854384AF12469DE2');
        $this->addSql('ALTER TABLE movies_has_categories DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE movies_has_categories RENAME INDEX idx_854384af8f93b6fc TO movie_id');
        $this->addSql('ALTER TABLE movies_has_categories RENAME INDEX idx_854384af12469de2 TO category_id');
    }
}
