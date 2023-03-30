<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214100827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vigneron_partenaire (vigneron_id INT NOT NULL, partenaire_id INT NOT NULL, INDEX IDX_C20D3D846B7EEB04 (vigneron_id), INDEX IDX_C20D3D8498DE13AC (partenaire_id), PRIMARY KEY(vigneron_id, partenaire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vigneron_animation (vigneron_id INT NOT NULL, animation_id INT NOT NULL, INDEX IDX_705F374C6B7EEB04 (vigneron_id), INDEX IDX_705F374C3858647E (animation_id), PRIMARY KEY(vigneron_id, animation_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vigneron_partenaire ADD CONSTRAINT FK_C20D3D846B7EEB04 FOREIGN KEY (vigneron_id) REFERENCES vigneron (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vigneron_partenaire ADD CONSTRAINT FK_C20D3D8498DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vigneron_animation ADD CONSTRAINT FK_705F374C6B7EEB04 FOREIGN KEY (vigneron_id) REFERENCES vigneron (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vigneron_animation ADD CONSTRAINT FK_705F374C3858647E FOREIGN KEY (animation_id) REFERENCES animation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vigneron DROP FOREIGN KEY FK_312238BE98DE13AC');
        $this->addSql('ALTER TABLE vigneron DROP FOREIGN KEY FK_312238BE3858647E');
        $this->addSql('DROP INDEX IDX_312238BE98DE13AC ON vigneron');
        $this->addSql('DROP INDEX IDX_312238BE3858647E ON vigneron');
        $this->addSql('ALTER TABLE vigneron DROP partenaire_id, DROP animation_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vigneron_partenaire DROP FOREIGN KEY FK_C20D3D846B7EEB04');
        $this->addSql('ALTER TABLE vigneron_partenaire DROP FOREIGN KEY FK_C20D3D8498DE13AC');
        $this->addSql('ALTER TABLE vigneron_animation DROP FOREIGN KEY FK_705F374C6B7EEB04');
        $this->addSql('ALTER TABLE vigneron_animation DROP FOREIGN KEY FK_705F374C3858647E');
        $this->addSql('DROP TABLE vigneron_partenaire');
        $this->addSql('DROP TABLE vigneron_animation');
        $this->addSql('ALTER TABLE vigneron ADD partenaire_id INT DEFAULT NULL, ADD animation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vigneron ADD CONSTRAINT FK_312238BE98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE vigneron ADD CONSTRAINT FK_312238BE3858647E FOREIGN KEY (animation_id) REFERENCES animation (id)');
        $this->addSql('CREATE INDEX IDX_312238BE98DE13AC ON vigneron (partenaire_id)');
        $this->addSql('CREATE INDEX IDX_312238BE3858647E ON vigneron (animation_id)');
    }
}
