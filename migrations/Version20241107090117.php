<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107090117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quest_user (quest_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_83997ABB209E9EF4 (quest_id), INDEX IDX_83997ABBA76ED395 (user_id), PRIMARY KEY(quest_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quest_user ADD CONSTRAINT FK_83997ABB209E9EF4 FOREIGN KEY (quest_id) REFERENCES quest (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quest_user ADD CONSTRAINT FK_83997ABBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quest_user DROP FOREIGN KEY FK_83997ABB209E9EF4');
        $this->addSql('ALTER TABLE quest_user DROP FOREIGN KEY FK_83997ABBA76ED395');
        $this->addSql('DROP TABLE quest_user');
    }
}
