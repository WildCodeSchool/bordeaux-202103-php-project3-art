<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210710205916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE image_happening (id INT AUTO_INCREMENT NOT NULL, image VARCHAR(255) DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE happening ADD image_happening_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE happening ADD CONSTRAINT FK_1F3C70ADBD7E7601 FOREIGN KEY (image_happening_id) REFERENCES image_happening (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F3C70ADBD7E7601 ON happening (image_happening_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE happening DROP FOREIGN KEY FK_1F3C70ADBD7E7601');
        $this->addSql('DROP TABLE image_happening');
        $this->addSql('DROP INDEX UNIQ_1F3C70ADBD7E7601 ON happening');
        $this->addSql('ALTER TABLE happening DROP image_happening_id');
    }
}
