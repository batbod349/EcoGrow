<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107091053 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiences CHANGE quest_id quest_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE experiences ADD CONSTRAINT FK_82020E70209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id)');
        $this->addSql('CREATE INDEX IDX_82020E70209E9EF4 ON experiences (quest_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE experiences DROP FOREIGN KEY FK_82020E70209E9EF4');
        $this->addSql('DROP INDEX IDX_82020E70209E9EF4 ON experiences');
        $this->addSql('ALTER TABLE experiences CHANGE quest_id quest_id INT NOT NULL');
    }
}
