<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221214095833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animation DROP FOREIGN KEY FK_8D5284DCE07707D7');
        $this->addSql('DROP INDEX IDX_8D5284DCE07707D7 ON animation');
        $this->addSql('ALTER TABLE animation DROP vignerons_id');
        $this->addSql('ALTER TABLE cru DROP FOREIGN KEY FK_88B632ACE07707D7');
        $this->addSql('DROP INDEX IDX_88B632ACE07707D7 ON cru');
        $this->addSql('ALTER TABLE cru DROP vignerons_id');
        $this->addSql('ALTER TABLE partenaire DROP FOREIGN KEY FK_32FFA373E07707D7');
        $this->addSql('DROP INDEX IDX_32FFA373E07707D7 ON partenaire');
        $this->addSql('ALTER TABLE partenaire DROP vignerons_id');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC27E07707D7');
        $this->addSql('DROP INDEX IDX_29A5EC27E07707D7 ON produit');
        $this->addSql('ALTER TABLE produit DROP vignerons_id');
        $this->addSql('ALTER TABLE vigneron ADD cru_id INT DEFAULT NULL, ADD produit_id INT DEFAULT NULL, ADD partenaire_id INT DEFAULT NULL, ADD animation_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE vigneron ADD CONSTRAINT FK_312238BE79512374 FOREIGN KEY (cru_id) REFERENCES cru (id)');
        $this->addSql('ALTER TABLE vigneron ADD CONSTRAINT FK_312238BEF347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('ALTER TABLE vigneron ADD CONSTRAINT FK_312238BE98DE13AC FOREIGN KEY (partenaire_id) REFERENCES partenaire (id)');
        $this->addSql('ALTER TABLE vigneron ADD CONSTRAINT FK_312238BE3858647E FOREIGN KEY (animation_id) REFERENCES animation (id)');
        $this->addSql('CREATE INDEX IDX_312238BE79512374 ON vigneron (cru_id)');
        $this->addSql('CREATE INDEX IDX_312238BEF347EFB ON vigneron (produit_id)');
        $this->addSql('CREATE INDEX IDX_312238BE98DE13AC ON vigneron (partenaire_id)');
        $this->addSql('CREATE INDEX IDX_312238BE3858647E ON vigneron (animation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE vigneron DROP FOREIGN KEY FK_312238BE79512374');
        $this->addSql('ALTER TABLE vigneron DROP FOREIGN KEY FK_312238BEF347EFB');
        $this->addSql('ALTER TABLE vigneron DROP FOREIGN KEY FK_312238BE98DE13AC');
        $this->addSql('ALTER TABLE vigneron DROP FOREIGN KEY FK_312238BE3858647E');
        $this->addSql('DROP INDEX IDX_312238BE79512374 ON vigneron');
        $this->addSql('DROP INDEX IDX_312238BEF347EFB ON vigneron');
        $this->addSql('DROP INDEX IDX_312238BE98DE13AC ON vigneron');
        $this->addSql('DROP INDEX IDX_312238BE3858647E ON vigneron');
        $this->addSql('ALTER TABLE vigneron DROP cru_id, DROP produit_id, DROP partenaire_id, DROP animation_id');
        $this->addSql('ALTER TABLE animation ADD vignerons_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE animation ADD CONSTRAINT FK_8D5284DCE07707D7 FOREIGN KEY (vignerons_id) REFERENCES vigneron (id)');
        $this->addSql('CREATE INDEX IDX_8D5284DCE07707D7 ON animation (vignerons_id)');
        $this->addSql('ALTER TABLE cru ADD vignerons_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cru ADD CONSTRAINT FK_88B632ACE07707D7 FOREIGN KEY (vignerons_id) REFERENCES vigneron (id)');
        $this->addSql('CREATE INDEX IDX_88B632ACE07707D7 ON cru (vignerons_id)');
        $this->addSql('ALTER TABLE partenaire ADD vignerons_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE partenaire ADD CONSTRAINT FK_32FFA373E07707D7 FOREIGN KEY (vignerons_id) REFERENCES vigneron (id)');
        $this->addSql('CREATE INDEX IDX_32FFA373E07707D7 ON partenaire (vignerons_id)');
        $this->addSql('ALTER TABLE produit ADD vignerons_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC27E07707D7 FOREIGN KEY (vignerons_id) REFERENCES vigneron (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC27E07707D7 ON produit (vignerons_id)');
    }
}
