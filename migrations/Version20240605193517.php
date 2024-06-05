<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605193517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE events_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE events (id INT NOT NULL, user_id INT NOT NULL, title VARCHAR(180) NOT NULL, description TEXT NOT NULL, date DATE NOT NULL, color VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5387574AA76ED395 ON events (user_id)');
        $this->addSql('ALTER TABLE events ADD CONSTRAINT FK_5387574AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER INDEX uniq_8d93d649e7927c74 RENAME TO UNIQ_1483A5E9E7927C74');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE events_id_seq CASCADE');
        $this->addSql('ALTER TABLE events DROP CONSTRAINT FK_5387574AA76ED395');
        $this->addSql('DROP TABLE events');
        $this->addSql('ALTER INDEX uniq_1483a5e9e7927c74 RENAME TO uniq_8d93d649e7927c74');
    }
}
