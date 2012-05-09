<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120508151859 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE layer ADD project_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE layer ADD CONSTRAINT FK_E4DB211A166D1F9C FOREIGN KEY (project_id) REFERENCES project(id)");
        $this->addSql("CREATE INDEX IDX_E4DB211A166D1F9C ON layer (project_id)");
        $this->addSql("CREATE INDEX IDX_E4DB211A166D1F9C ON layer (project_id)");

        $this->addSql("UPDATE layer inner join sequences_layers on layer.id = sequences_layers.layer_id inner join sequence on sequences_layers.sequence_id = sequence.id set layer.project_id = sequence.project_id"); 
    }

    public function down(Schema $schema)
    {
        // this down() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        $this->addSql("ALTER TABLE layer DROP FOREIGN KEY FK_E4DB211A166D1F9C");
        $this->addSql("DROP INDEX IDX_E4DB211A166D1F9C ON layer");
        $this->addSql("ALTER TABLE layer DROP project_id");
    }
}
