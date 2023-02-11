<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221225155047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire ADD animation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA3733858647E FOREIGN KEY (animation_id) REFERENCES animation (id)');
        $this->addSql('CREATE INDEX IDX_32FFA3733858647E ON partenaire (animation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA3733858647E');
        $this->addSql('DROP INDEX IDX_32FFA3733858647E ON partenaire');
        $this->addSql('ALTER TABLE partenaire DROP animation_id');
    }
}
