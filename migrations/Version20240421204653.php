<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240421204653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE workers (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, type VARCHAR(255) NOT NULL, salary VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, name, surname, email FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, surname VARCHAR(255) DEFAULT NULL, email VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO users (id, name, surname, email) SELECT id, name, surname, email FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE workers');
        $this->addSql('CREATE TEMPORARY TABLE __temp__users AS SELECT id, name, surname, email FROM users');
        $this->addSql('DROP TABLE users');
        $this->addSql('CREATE TABLE users (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, surname CLOB DEFAULT NULL, email VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO users (id, name, surname, email) SELECT id, name, surname, email FROM __temp__users');
        $this->addSql('DROP TABLE __temp__users');
    }
}
