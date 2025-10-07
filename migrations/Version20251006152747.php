<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251006152747 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointement_service (appointement_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_EFF7DFEF1EBF5025 (appointement_id), INDEX IDX_EFF7DFEFED5CA9E6 (service_id), PRIMARY KEY(appointement_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointement_service ADD CONSTRAINT FK_EFF7DFEF1EBF5025 FOREIGN KEY (appointement_id) REFERENCES appointement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointement_service ADD CONSTRAINT FK_EFF7DFEFED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE appointement DROP service');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointement_service DROP FOREIGN KEY FK_EFF7DFEF1EBF5025');
        $this->addSql('ALTER TABLE appointement_service DROP FOREIGN KEY FK_EFF7DFEFED5CA9E6');
        $this->addSql('DROP TABLE appointement_service');
        $this->addSql('ALTER TABLE appointement ADD service VARCHAR(255) NOT NULL');
    }
}
