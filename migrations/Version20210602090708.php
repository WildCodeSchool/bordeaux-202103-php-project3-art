<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210602090708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE discipline_user (discipline_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_58EFE1A7A5522701 (discipline_id), INDEX IDX_58EFE1A7A76ED395 (user_id), PRIMARY KEY(discipline_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_happening (tag_id INT NOT NULL, happening_id INT NOT NULL, INDEX IDX_E0B4A8ABAD26311 (tag_id), INDEX IDX_E0B4A8AB7B10E6D (happening_id), PRIMARY KEY(tag_id, happening_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_announcement (tag_id INT NOT NULL, announcement_id INT NOT NULL, INDEX IDX_EDAFF21EBAD26311 (tag_id), INDEX IDX_EDAFF21E913AEA17 (announcement_id), PRIMARY KEY(tag_id, announcement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_article (tag_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_300B23CCBAD26311 (tag_id), INDEX IDX_300B23CC7294869C (article_id), PRIMARY KEY(tag_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE discipline_user ADD CONSTRAINT FK_58EFE1A7A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_user ADD CONSTRAINT FK_58EFE1A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_happening ADD CONSTRAINT FK_E0B4A8ABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_happening ADD CONSTRAINT FK_E0B4A8AB7B10E6D FOREIGN KEY (happening_id) REFERENCES happening (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_announcement ADD CONSTRAINT FK_EDAFF21EBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_announcement ADD CONSTRAINT FK_EDAFF21E913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_article ADD CONSTRAINT FK_300B23CCBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_article ADD CONSTRAINT FK_300B23CC7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE announcement ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4DB9D91CA76ED395 ON announcement (user_id)');
        $this->addSql('ALTER TABLE article ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66A76ED395 ON article (user_id)');
        $this->addSql('ALTER TABLE artwork ADD discipline_id INT NOT NULL, ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_881FC576A5522701 ON artwork (discipline_id)');
        $this->addSql('CREATE INDEX IDX_881FC576A76ED395 ON artwork (user_id)');
        $this->addSql('ALTER TABLE avatar ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE avatar ADD CONSTRAINT FK_1677722FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1677722FA76ED395 ON avatar (user_id)');
        $this->addSql('ALTER TABLE happening ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE happening ADD CONSTRAINT FK_1F3C70ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_1F3C70ADA76ED395 ON happening (user_id)');
        $this->addSql('ALTER TABLE message ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FA76ED395 ON message (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE discipline_user');
        $this->addSql('DROP TABLE tag_happening');
        $this->addSql('DROP TABLE tag_announcement');
        $this->addSql('DROP TABLE tag_article');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CA76ED395');
        $this->addSql('DROP INDEX IDX_4DB9D91CA76ED395 ON announcement');
        $this->addSql('ALTER TABLE announcement DROP user_id');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('DROP INDEX IDX_23A0E66A76ED395 ON article');
        $this->addSql('ALTER TABLE article DROP user_id');
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC576A5522701');
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC576A76ED395');
        $this->addSql('DROP INDEX IDX_881FC576A5522701 ON artwork');
        $this->addSql('DROP INDEX IDX_881FC576A76ED395 ON artwork');
        $this->addSql('ALTER TABLE artwork DROP discipline_id, DROP user_id');
        $this->addSql('ALTER TABLE avatar DROP FOREIGN KEY FK_1677722FA76ED395');
        $this->addSql('DROP INDEX UNIQ_1677722FA76ED395 ON avatar');
        $this->addSql('ALTER TABLE avatar DROP user_id');
        $this->addSql('ALTER TABLE happening DROP FOREIGN KEY FK_1F3C70ADA76ED395');
        $this->addSql('DROP INDEX IDX_1F3C70ADA76ED395 ON happening');
        $this->addSql('ALTER TABLE happening DROP user_id');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('DROP INDEX IDX_B6BD307FA76ED395 ON message');
        $this->addSql('ALTER TABLE message DROP user_id');
    }
}
