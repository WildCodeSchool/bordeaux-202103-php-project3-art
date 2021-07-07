<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210707152809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image_article (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CA5522701');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE article ADD image_article_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E661E4A91AA FOREIGN KEY (image_article_id) REFERENCES image_article (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_23A0E661E4A91AA ON article (image_article_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E661E4A91AA');
        $this->addSql('DROP TABLE image_article');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CA5522701');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CA5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP INDEX UNIQ_23A0E661E4A91AA ON article');
        $this->addSql('ALTER TABLE article DROP image_article_id');
    }
}
