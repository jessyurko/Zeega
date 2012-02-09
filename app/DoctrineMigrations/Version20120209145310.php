<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20120209145310 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is autogenerated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
        
        
        $this->addSql("ALTER TABLE Node RENAME Frame");
		$this->addSql("ALTER TABLE Route RENAME Sequence");
		$this->addSql("ALTER TABLE Playground RENAME Site");
		$this->addSql("ALTER TABLE Users_Playgrounds RENAME users_sites");
		$this->addSql("ALTER TABLE routes_layers RENAME sequences_layers");		
        $this->addSql("ALTER TABLE Item DROP FOREIGN KEY FK_BF298A20F8FE9381");
        $this->addSql("DROP INDEX IDX_BF298A20F8FE9381 ON Item");
        $this->addSql("ALTER TABLE Item CHANGE playground_id sequence_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Project CHANGE playground_id site_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Item ADD CONSTRAINT FK_BF298A20F6BD1646 FOREIGN KEY (site_id) REFERENCES Site(id)");
        $this->addSql("CREATE INDEX IDX_BF298A20F6BD1646 ON Item (site_id)");
        $this->addSql("ALTER TABLE Project DROP FOREIGN KEY FK_E00EE972F8FE9381");
        $this->addSql("DROP INDEX IDX_E00EE972F8FE9381 ON Project");
        $this->addSql("ALTER TABLE Project ADD CONSTRAINT FK_E00EE972F6BD1646 FOREIGN KEY (site_id) REFERENCES Site(id)");
        $this->addSql("CREATE INDEX IDX_E00EE972F6BD1646 ON Project (site_id)");
		
    }

    public function down(Schema $schema)
    {
    }
}
