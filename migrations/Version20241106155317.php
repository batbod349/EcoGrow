<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241106155317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE badges (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE badges_user (badges_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_C417C533538DA1D0 (badges_id), INDEX IDX_C417C533A76ED395 (user_id), PRIMARY KEY(badges_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE badges_user ADD CONSTRAINT FK_C417C533538DA1D0 FOREIGN KEY (badges_id) REFERENCES badges (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE badges_user ADD CONSTRAINT FK_C417C533A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE experiences ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiences ADD CONSTRAINT FK_82020E70A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_82020E70A76ED395 ON experiences (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE badges_user DROP FOREIGN KEY FK_C417C533538DA1D0');
        $this->addSql('ALTER TABLE badges_user DROP FOREIGN KEY FK_C417C533A76ED395');
        $this->addSql('DROP TABLE badges');
        $this->addSql('DROP TABLE badges_user');
        $this->addSql('ALTER TABLE experiences DROP FOREIGN KEY FK_82020E70A76ED395');
        $this->addSql('DROP INDEX IDX_82020E70A76ED395 ON experiences');
        $this->addSql('ALTER TABLE experiences DROP user_id');
    }
}
