<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210624083328 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB913AEA17');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE response DROP FOREIGN KEY FK_3E7B0BFB913AEA17');
        $this->addSql('ALTER TABLE response ADD CONSTRAINT FK_3E7B0BFB913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
