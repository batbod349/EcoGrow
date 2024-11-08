<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241107201715 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tips ADD tips1_title VARCHAR(255) DEFAULT NULL, ADD tips1_image LONGBLOB DEFAULT NULL, ADD tips2_title VARCHAR(255) DEFAULT NULL, ADD tips2_image LONGBLOB DEFAULT NULL, ADD tips3_title VARCHAR(255) DEFAULT NULL, ADD tips3_image LONGBLOB DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tips DROP tips1_title, DROP tips1_image, DROP tips2_title, DROP tips2_image, DROP tips3_title, DROP tips3_image');
    }
}
