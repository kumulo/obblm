<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821101609 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE championship ADD rule_id INT NOT NULL');
        $this->addSql('ALTER TABLE championship ADD CONSTRAINT FK_EBADDE6A744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id)');
        $this->addSql('CREATE INDEX IDX_EBADDE6A744E0351 ON championship (rule_id)');
        $this->addSql('ALTER TABLE team ADD rule_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id)');
        $this->addSql('CREATE INDEX IDX_C4E0A61F744E0351 ON team (rule_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE championship DROP FOREIGN KEY FK_EBADDE6A744E0351');
        $this->addSql('DROP INDEX IDX_EBADDE6A744E0351 ON championship');
        $this->addSql('ALTER TABLE championship DROP rule_id');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F744E0351');
        $this->addSql('DROP INDEX IDX_C4E0A61F744E0351 ON team');
        $this->addSql('ALTER TABLE team DROP rule_id');
    }
}
