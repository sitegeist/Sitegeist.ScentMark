<?php

declare(strict_types=1);

namespace Neos\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240513115016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        $this->addSql('CREATE UNIQUE INDEX UNIQ_67996EDC1D775834 ON sitegeist_scentmark_domain_model_scent (value)');
    }

    public function down(Schema $schema): void
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        $this->addSql('DROP INDEX UNIQ_67996EDC1D775834 ON sitegeist_scentmark_domain_model_scent');
    }
}
