<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200519090854 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dresseur ADD starter_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE dresseur ADD CONSTRAINT FK_77EA2FC6AD5A66CC FOREIGN KEY (starter_id) REFERENCES ref_pokemon_type (id)');
        $this->addSql('CREATE INDEX IDX_77EA2FC6AD5A66CC ON dresseur (starter_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dresseur DROP FOREIGN KEY FK_77EA2FC6AD5A66CC');
        $this->addSql('DROP INDEX IDX_77EA2FC6AD5A66CC ON dresseur');
        $this->addSql('ALTER TABLE dresseur DROP starter_id');
    }
}
