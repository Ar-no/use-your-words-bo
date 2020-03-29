<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200329165947 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE answer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, used_scene_id INTEGER NOT NULL, player_id INTEGER NOT NULL, answer VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_DADD4A25DC5D461B ON answer (used_scene_id)');
        $this->addSql('CREATE INDEX IDX_DADD4A2599E6F5DF ON answer (player_id)');
        $this->addSql('CREATE TABLE party (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, access_code VARCHAR(5) NOT NULL, current_step INTEGER NOT NULL, creation_date DATE NOT NULL)');
        $this->addSql('CREATE TABLE player (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, party_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE INDEX IDX_98197A65213C1059 ON player (party_id)');
        $this->addSql('CREATE TABLE scene (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, url VARCHAR(255) NOT NULL)');
        $this->addSql('CREATE TABLE used_scene (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, party_id INTEGER NOT NULL, scene_id INTEGER NOT NULL, step INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_3FB5BD76213C1059 ON used_scene (party_id)');
        $this->addSql('CREATE INDEX IDX_3FB5BD76166053B4 ON used_scene (scene_id)');
        $this->addSql('CREATE TABLE vote (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, player_id INTEGER NOT NULL, answer_id INTEGER NOT NULL)');
        $this->addSql('CREATE INDEX IDX_5A10856499E6F5DF ON vote (player_id)');
        $this->addSql('CREATE INDEX IDX_5A108564AA334807 ON vote (answer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE party');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE scene');
        $this->addSql('DROP TABLE used_scene');
        $this->addSql('DROP TABLE vote');
    }
}
