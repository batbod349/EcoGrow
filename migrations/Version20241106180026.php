<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241106180026 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE badges DROP name, DROP description, DROP type');
        $this->addSql('ALTER TABLE experiences DROP FOREIGN KEY FK_82020E70A76ED395');
        $this->addSql('DROP INDEX IDX_82020E70A76ED395 ON experiences');
        $this->addSql('ALTER TABLE experiences DROP user_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiences ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiences ADD CONSTRAINT FK_82020E70A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_82020E70A76ED395 ON experiences (user_id)');
        $this->addSql('ALTER TABLE badges ADD name VARCHAR(255) NOT NULL, ADD description LONGTEXT NOT NULL, ADD type VARCHAR(255) NOT NULL');
    }
}
