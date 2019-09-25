<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190919125111 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE session (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', market VARCHAR(255) NOT NULL, pair VARCHAR(255) NOT NULL, status VARCHAR(15) NOT NULL, price_watched DOUBLE PRECISION NOT NULL, watched_at DATETIME NOT NULL, price_buyed DOUBLE PRECISION DEFAULT NULL, buyed_at DATETIME DEFAULT NULL, quantity_buyed DOUBLE PRECISION DEFAULT NULL, price_sold DOUBLE PRECISION DEFAULT NULL, sold_at DATETIME DEFAULT NULL, market_buy_order_id VARCHAR(255) DEFAULT NULL, market_sell_order_id VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session_log (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', session_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:uuid)\', status VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F2E6F0FF613FECDF (session_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE session_log ADD CONSTRAINT FK_F2E6F0FF613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE session_log DROP FOREIGN KEY FK_F2E6F0FF613FECDF');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE session_log');
    }
}
