<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221210182350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cru ADD vignerons_cru_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE cru ADD CONSTRAINT FK_88B632ACD4264838 FOREIGN KEY (vignerons_cru_id) REFERENCES vigneron (id)');
        $this->addSql('CREATE INDEX IDX_88B632ACD4264838 ON cru (vignerons_cru_id)');
        $this->addSql('ALTER TABLE produit ADD vignerons_prod_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC277E0F45A5 FOREIGN KEY (vignerons_prod_id) REFERENCES vigneron (id)');
        $this->addSql('CREATE INDEX IDX_29A5EC277E0F45A5 ON produit (vignerons_prod_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cru DROP FOREIGN KEY FK_88B632ACD4264838');
        $this->addSql('DROP INDEX IDX_88B632ACD4264838 ON cru');
        $this->addSql('ALTER TABLE cru DROP vignerons_cru_id');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC277E0F45A5');
        $this->addSql('DROP INDEX IDX_29A5EC277E0F45A5 ON produit');
        $this->addSql('ALTER TABLE produit DROP vignerons_prod_id');
    }
}
