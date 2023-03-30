<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230131203541 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte ADD cru_r_id INT NOT NULL');
        $this->addSql('ALTER TABLE carte ADD CONSTRAINT FK_BAD4FFFDF92B096E FOREIGN KEY (cru_r_id) REFERENCES cru (id)');
        $this->addSql('CREATE INDEX IDX_BAD4FFFDF92B096E ON carte (cru_r_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte DROP FOREIGN KEY FK_BAD4FFFDF92B096E');
        $this->addSql('DROP INDEX IDX_BAD4FFFDF92B096E ON carte');
        $this->addSql('ALTER TABLE carte DROP cru_r_id');
    }
}
