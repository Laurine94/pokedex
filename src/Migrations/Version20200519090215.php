<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200519090215 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE pokemon_existant (id INT AUTO_INCREMENT NOT NULL, pokemon_type_id INT DEFAULT NULL, dresseur_id INT DEFAULT NULL, sexe VARCHAR(10) DEFAULT NULL, xp INT DEFAULT NULL, niveau INT DEFAULT NULL, prix INT DEFAULT NULL, INDEX IDX_351D8709A926F002 (pokemon_type_id), INDEX IDX_351D8709A1A01CBE (dresseur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE pokemon_existant ADD CONSTRAINT FK_351D8709A926F002 FOREIGN KEY (pokemon_type_id) REFERENCES ref_pokemon_type (id)');
        $this->addSql('ALTER TABLE pokemon_existant ADD CONSTRAINT FK_351D8709A1A01CBE FOREIGN KEY (dresseur_id) REFERENCES dresseur (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE pokemon_existant');
    }
}
