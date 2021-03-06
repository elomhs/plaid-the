<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191128142115 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE comment (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, room_id INTEGER DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL, client VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_9474526C54177093 ON comment (room_id)');
        $this->addSql('CREATE TABLE reservation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, reservation_id INTEGER DEFAULT NULL, clients_id INTEGER DEFAULT NULL, date_debut VARCHAR(255) DEFAULT NULL, date_fin VARCHAR(255) DEFAULT NULL, owner VARCHAR(255) DEFAULT NULL, client VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_42C84955B83297E7 ON reservation (reservation_id)');
        $this->addSql('CREATE INDEX IDX_42C84955AB014612 ON reservation (clients_id)');
        $this->addSql('CREATE TABLE unavailable_period (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, date_debut VARCHAR(255) DEFAULT NULL, date_fin VARCHAR(255) DEFAULT NULL)');
        $this->addSql('DROP INDEX UNIQ_C7440455A76ED395');
        $this->addSql('DROP INDEX UNIQ_C7440455D60322AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, role_id, user_id, name, mdp, comment FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL COLLATE BINARY, mdp VARCHAR(255) DEFAULT NULL COLLATE BINARY, comment VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_C7440455D60322AC FOREIGN KEY (role_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C7440455A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO client (id, role_id, user_id, name, mdp, comment) SELECT id, role_id, user_id, name, mdp, comment FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455A76ED395 ON client (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455D60322AC ON client (role_id)');
        $this->addSql('DROP INDEX UNIQ_CF60E67CA76ED395');
        $this->addSql('DROP INDEX UNIQ_CF60E67CD60322AC');
        $this->addSql('CREATE TEMPORARY TABLE __temp__owner AS SELECT id, role_id, user_id, firstname, family_name, address, country FROM owner');
        $this->addSql('DROP TABLE owner');
        $this->addSql('CREATE TABLE owner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, firstname VARCHAR(255) NOT NULL COLLATE BINARY, family_name VARCHAR(255) NOT NULL COLLATE BINARY, address CLOB DEFAULT NULL COLLATE BINARY, country VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_CF60E67CD60322AC FOREIGN KEY (role_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_CF60E67CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO owner (id, role_id, user_id, firstname, family_name, address, country) SELECT id, role_id, user_id, firstname, family_name, address, country FROM __temp__owner');
        $this->addSql('DROP TABLE __temp__owner');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF60E67CA76ED395 ON owner (user_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF60E67CD60322AC ON owner (role_id)');
        $this->addSql('DROP INDEX IDX_729F519B7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, owner_id, summary, description, capacity, superficy, price, address, image FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, summary VARCHAR(255) NOT NULL COLLATE BINARY, description VARCHAR(255) NOT NULL COLLATE BINARY, capacity INTEGER NOT NULL, superficy DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL COLLATE BINARY, image VARCHAR(255) DEFAULT NULL COLLATE BINARY, CONSTRAINT FK_729F519B7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room (id, owner_id, summary, description, capacity, superficy, price, address, image) SELECT id, owner_id, summary, description, capacity, superficy, price, address, image FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B7E3C61F9 ON room (owner_id)');
        $this->addSql('DROP INDEX IDX_4E2C37B798260155');
        $this->addSql('DROP INDEX IDX_4E2C37B754177093');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room_region AS SELECT room_id, region_id FROM room_region');
        $this->addSql('DROP TABLE room_region');
        $this->addSql('CREATE TABLE room_region (room_id INTEGER NOT NULL, region_id INTEGER NOT NULL, PRIMARY KEY(room_id, region_id), CONSTRAINT FK_4E2C37B754177093 FOREIGN KEY (room_id) REFERENCES room (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_4E2C37B798260155 FOREIGN KEY (region_id) REFERENCES region (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO room_region (room_id, region_id) SELECT room_id, region_id FROM __temp__room_region');
        $this->addSql('DROP TABLE __temp__room_region');
        $this->addSql('CREATE INDEX IDX_4E2C37B798260155 ON room_region (region_id)');
        $this->addSql('CREATE INDEX IDX_4E2C37B754177093 ON room_region (room_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE unavailable_period');
        $this->addSql('DROP INDEX UNIQ_C7440455D60322AC');
        $this->addSql('DROP INDEX UNIQ_C7440455A76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__client AS SELECT id, role_id, user_id, name, mdp, comment FROM client');
        $this->addSql('DROP TABLE client');
        $this->addSql('CREATE TABLE client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, mdp VARCHAR(255) DEFAULT NULL, comment VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO client (id, role_id, user_id, name, mdp, comment) SELECT id, role_id, user_id, name, mdp, comment FROM __temp__client');
        $this->addSql('DROP TABLE __temp__client');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455D60322AC ON client (role_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7440455A76ED395 ON client (user_id)');
        $this->addSql('DROP INDEX UNIQ_CF60E67CD60322AC');
        $this->addSql('DROP INDEX UNIQ_CF60E67CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__owner AS SELECT id, role_id, user_id, firstname, family_name, address, country FROM owner');
        $this->addSql('DROP TABLE owner');
        $this->addSql('CREATE TABLE owner (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, role_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, firstname VARCHAR(255) NOT NULL, family_name VARCHAR(255) NOT NULL, address CLOB DEFAULT NULL, country VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO owner (id, role_id, user_id, firstname, family_name, address, country) SELECT id, role_id, user_id, firstname, family_name, address, country FROM __temp__owner');
        $this->addSql('DROP TABLE __temp__owner');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF60E67CD60322AC ON owner (role_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CF60E67CA76ED395 ON owner (user_id)');
        $this->addSql('DROP INDEX IDX_729F519B7E3C61F9');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room AS SELECT id, owner_id, summary, description, capacity, superficy, price, address, image FROM room');
        $this->addSql('DROP TABLE room');
        $this->addSql('CREATE TABLE room (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, summary VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, capacity INTEGER NOT NULL, superficy DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, address VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO room (id, owner_id, summary, description, capacity, superficy, price, address, image) SELECT id, owner_id, summary, description, capacity, superficy, price, address, image FROM __temp__room');
        $this->addSql('DROP TABLE __temp__room');
        $this->addSql('CREATE INDEX IDX_729F519B7E3C61F9 ON room (owner_id)');
        $this->addSql('DROP INDEX IDX_4E2C37B754177093');
        $this->addSql('DROP INDEX IDX_4E2C37B798260155');
        $this->addSql('CREATE TEMPORARY TABLE __temp__room_region AS SELECT room_id, region_id FROM room_region');
        $this->addSql('DROP TABLE room_region');
        $this->addSql('CREATE TABLE room_region (room_id INTEGER NOT NULL, region_id INTEGER NOT NULL, PRIMARY KEY(room_id, region_id))');
        $this->addSql('INSERT INTO room_region (room_id, region_id) SELECT room_id, region_id FROM __temp__room_region');
        $this->addSql('DROP TABLE __temp__room_region');
        $this->addSql('CREATE INDEX IDX_4E2C37B754177093 ON room_region (room_id)');
        $this->addSql('CREATE INDEX IDX_4E2C37B798260155 ON room_region (region_id)');
    }
}
