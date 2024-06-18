<?php

declare(strict_types=1);

namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240618101320 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        $this->addSql('DROP INDEX uniq_67996edc1d775834 ON sitegeist_scentmark_domain_model_scent');
        $this->addSql('ALTER TABLE sitegeist_scentmark_domain_model_scent RENAME TO sitegeist_scentmark_domain_model_pack');
        $this->addSql('ALTER TABLE sitegeist_scentmark_domain_model_pack CHANGE value packscent VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sitegeist_scentmark_domain_model_pack ADD leaderscent VARCHAR(255), ADD leadexpiration DATETIME');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7C4F484066ACC98E ON sitegeist_scentmark_domain_model_pack (packScent)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        $this->addSql('DROP INDEX uniq_7c4f484066acc98e ON sitegeist_scentmark_domain_model_pack');
        $this->addSql('ALTER TABLE sitegeist_scentmark_domain_model_pack DROP leaderscent, DROP leadexpiration');
        $this->addSql('ALTER TABLE sitegeist_scentmark_domain_model_pack CHANGE packscent value VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE sitegeist_scentmark_domain_model_pack RENAME TO sitegeist_scentmark_domain_model_scent');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_67996EDC1D775834 ON sitegeist_scentmark_domain_model_scebt (value)');
    }
}
