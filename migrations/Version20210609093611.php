<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210609093611 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE announcement (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, date DATE DEFAULT NULL, time TIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_4DB9D91CA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_23A0E66A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE artwork (id INT AUTO_INCREMENT NOT NULL, discipline_id INT NOT NULL, user_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_881FC576A5522701 (discipline_id), INDEX IDX_881FC576A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avatar (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, url VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_1677722FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, identifier VARCHAR(255) DEFAULT NULL, color VARCHAR(7) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE discipline_user (discipline_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_58EFE1A7A5522701 (discipline_id), INDEX IDX_58EFE1A7A76ED395 (user_id), PRIMARY KEY(discipline_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE happening (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, media VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, time_start TIME DEFAULT NULL, time_end TIME DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_1F3C70ADA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, artwork_id INT NOT NULL, url VARCHAR(255) NOT NULL, support VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_6A2CA10CDB8FFA4 (artwork_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, mail VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, object VARCHAR(255) DEFAULT NULL, send_at DATETIME NOT NULL, is_read TINYINT(1) NOT NULL, INDEX IDX_B6BD307FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_happening (tag_id INT NOT NULL, happening_id INT NOT NULL, INDEX IDX_E0B4A8ABAD26311 (tag_id), INDEX IDX_E0B4A8AB7B10E6D (happening_id), PRIMARY KEY(tag_id, happening_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_announcement (tag_id INT NOT NULL, announcement_id INT NOT NULL, INDEX IDX_EDAFF21EBAD26311 (tag_id), INDEX IDX_EDAFF21E913AEA17 (announcement_id), PRIMARY KEY(tag_id, announcement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_article (tag_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_300B23CCBAD26311 (tag_id), INDEX IDX_300B23CC7294869C (article_id), PRIMARY KEY(tag_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, description LONGTEXT DEFAULT NULL, zip_code INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, expertise VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE announcement ADD CONSTRAINT FK_4DB9D91CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id)');
        $this->addSql('ALTER TABLE artwork ADD CONSTRAINT FK_881FC576A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE avatar ADD CONSTRAINT FK_1677722FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE discipline_user ADD CONSTRAINT FK_58EFE1A7A5522701 FOREIGN KEY (discipline_id) REFERENCES discipline (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE discipline_user ADD CONSTRAINT FK_58EFE1A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE happening ADD CONSTRAINT FK_1F3C70ADA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10CDB8FFA4 FOREIGN KEY (artwork_id) REFERENCES artwork (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tag_happening ADD CONSTRAINT FK_E0B4A8ABAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_happening ADD CONSTRAINT FK_E0B4A8AB7B10E6D FOREIGN KEY (happening_id) REFERENCES happening (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_announcement ADD CONSTRAINT FK_EDAFF21EBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_announcement ADD CONSTRAINT FK_EDAFF21E913AEA17 FOREIGN KEY (announcement_id) REFERENCES announcement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_article ADD CONSTRAINT FK_300B23CCBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_article ADD CONSTRAINT FK_300B23CC7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag_announcement DROP FOREIGN KEY FK_EDAFF21E913AEA17');
        $this->addSql('ALTER TABLE tag_article DROP FOREIGN KEY FK_300B23CC7294869C');
        $this->addSql('ALTER TABLE media DROP FOREIGN KEY FK_6A2CA10CDB8FFA4');
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC576A5522701');
        $this->addSql('ALTER TABLE discipline_user DROP FOREIGN KEY FK_58EFE1A7A5522701');
        $this->addSql('ALTER TABLE tag_happening DROP FOREIGN KEY FK_E0B4A8AB7B10E6D');
        $this->addSql('ALTER TABLE tag_happening DROP FOREIGN KEY FK_E0B4A8ABAD26311');
        $this->addSql('ALTER TABLE tag_announcement DROP FOREIGN KEY FK_EDAFF21EBAD26311');
        $this->addSql('ALTER TABLE tag_article DROP FOREIGN KEY FK_300B23CCBAD26311');
        $this->addSql('ALTER TABLE announcement DROP FOREIGN KEY FK_4DB9D91CA76ED395');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A76ED395');
        $this->addSql('ALTER TABLE artwork DROP FOREIGN KEY FK_881FC576A76ED395');
        $this->addSql('ALTER TABLE avatar DROP FOREIGN KEY FK_1677722FA76ED395');
        $this->addSql('ALTER TABLE discipline_user DROP FOREIGN KEY FK_58EFE1A7A76ED395');
        $this->addSql('ALTER TABLE happening DROP FOREIGN KEY FK_1F3C70ADA76ED395');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE announcement');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE artwork');
        $this->addSql('DROP TABLE avatar');
        $this->addSql('DROP TABLE discipline');
        $this->addSql('DROP TABLE discipline_user');
        $this->addSql('DROP TABLE happening');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_happening');
        $this->addSql('DROP TABLE tag_announcement');
        $this->addSql('DROP TABLE tag_article');
        $this->addSql('DROP TABLE user');
    }
}
