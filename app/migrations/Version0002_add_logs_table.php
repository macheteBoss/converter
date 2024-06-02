<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version0002_add_logs_table extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE compute_log (id INT AUTO_INCREMENT NOT NULL, rate_id INT NOT NULL, date DATETIME NOT NULL, sum BIGINT NOT NULL, result DECIMAL(50, 20) NOT NULL, INDEX IDX_1F000F0EBC999F9F (rate_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE compute_log ADD CONSTRAINT FK_1F000F0EBC999F9F FOREIGN KEY (rate_id) REFERENCES rate (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE compute_log DROP FOREIGN KEY FK_1F000F0EBC999F9F');
        $this->addSql('DROP TABLE compute_log');
    }
}
