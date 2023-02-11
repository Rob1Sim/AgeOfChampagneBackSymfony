<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221207091739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte ADD vignerons_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE carte ADD CONSTRAINT FK_BAD4FFFDE07707D7 FOREIGN KEY (vignerons_id) REFERENCES vigneron (id)');
        $this->addSql('CREATE INDEX IDX_BAD4FFFDE07707D7 ON carte (vignerons_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte DROP FOREIGN KEY FK_BAD4FFFDE07707D7');
        $this->addSql('DROP INDEX IDX_BAD4FFFDE07707D7 ON carte');
        $this->addSql('ALTER TABLE carte DROP vignerons_id');
    }
}
