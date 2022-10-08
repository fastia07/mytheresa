<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221008144800 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create the initial tables for leave approval system';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE manager (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE request (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, author INTEGER NOT NULL, status VARCHAR(255) NOT NULL, resolved_by INTEGER NULL, request_created_at DATETIME NOT NULL, vacation_start_date DATETIME NOT NULL, vacation_end_date DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX status_index ON request (status)');
        $this->addSql('CREATE TABLE worker (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, leave_balance INTEGER NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE manager');
        $this->addSql('DROP TABLE request');
        $this->addSql('DROP TABLE worker');
    }
}
