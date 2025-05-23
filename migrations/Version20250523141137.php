<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250523141137 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1F1512DD5E237E06 ON campaign (name)');
        $this->addSql('ALTER TABLE influencer ADD campaign_id INT NOT NULL');
        $this->addSql('ALTER TABLE influencer ADD CONSTRAINT FK_3D9F8CA3F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D9F8CA35E237E06 ON influencer (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3D9F8CA3E7927C74 ON influencer (email)');
        $this->addSql('CREATE INDEX IDX_3D9F8CA3F639F774 ON influencer (campaign_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_1F1512DD5E237E06 ON campaign');
        $this->addSql('ALTER TABLE influencer DROP FOREIGN KEY FK_3D9F8CA3F639F774');
        $this->addSql('DROP INDEX UNIQ_3D9F8CA35E237E06 ON influencer');
        $this->addSql('DROP INDEX UNIQ_3D9F8CA3E7927C74 ON influencer');
        $this->addSql('DROP INDEX IDX_3D9F8CA3F639F774 ON influencer');
        $this->addSql('ALTER TABLE influencer DROP campaign_id');
    }
}
