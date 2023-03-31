<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230107160250 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carte_compte (carte_id INT NOT NULL, compte_id INT NOT NULL, INDEX IDX_D9123251C9C7CEB6 (carte_id), INDEX IDX_D9123251F2C56620 (compte_id), PRIMARY KEY(carte_id, compte_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carte_compte ADD CONSTRAINT FK_D9123251C9C7CEB6 FOREIGN KEY (carte_id) REFERENCES carte (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carte_compte ADD CONSTRAINT FK_D9123251F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_compte DROP FOREIGN KEY FK_D9123251C9C7CEB6');
        $this->addSql('ALTER TABLE carte_compte DROP FOREIGN KEY FK_D9123251F2C56620');
        $this->addSql('DROP TABLE carte_compte');
    }
}
