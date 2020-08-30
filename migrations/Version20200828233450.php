<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828233450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE championship (id INT AUTO_INCREMENT NOT NULL, league_id INT NOT NULL, rule_id INT NOT NULL, name VARCHAR(255) NOT NULL, format VARCHAR(50) NOT NULL, tie_break_1 VARCHAR(255) NOT NULL, tie_break_2 VARCHAR(255) NOT NULL, tie_break_3 VARCHAR(255) NOT NULL, auto_validate_games TINYINT(1) NOT NULL, number_of_journeys INT DEFAULT NULL, is_private TINYINT(1) NOT NULL, is_locked TINYINT(1) NOT NULL, max_teams INT NOT NULL, INDEX IDX_EBADDE6A58AFC4DE (league_id), INDEX IDX_EBADDE6A744E0351 (rule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE championship_manager (championship_id INT NOT NULL, coach_id INT NOT NULL, INDEX IDX_CE3DF45194DDBCE9 (championship_id), INDEX IDX_CE3DF4513C105691 (coach_id), PRIMARY KEY(championship_id, coach_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE championship_coach (championship_id INT NOT NULL, coach_id INT NOT NULL, INDEX IDX_307D92CD94DDBCE9 (championship_id), INDEX IDX_307D92CD3C105691 (coach_id), PRIMARY KEY(championship_id, coach_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE championship_invitation (id INT AUTO_INCREMENT NOT NULL, championship_id INT NOT NULL, email VARCHAR(255) NOT NULL, hash VARCHAR(255) DEFAULT NULL, INDEX IDX_AAA4BC1094DDBCE9 (championship_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coach (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, username VARCHAR(255) NOT NULL, active TINYINT(1) NOT NULL, hash VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3F596DCCE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE game (id INT AUTO_INCREMENT NOT NULL, championship_id INT NOT NULL, journey_id INT NOT NULL, home_team_id INT NOT NULL, visitor_team_id INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, validated_at DATETIME DEFAULT NULL, INDEX IDX_232B318C94DDBCE9 (championship_id), INDEX IDX_232B318CD5C9896F (journey_id), INDEX IDX_232B318C9C4C13F6 (home_team_id), INDEX IDX_232B318CEB7F4866 (visitor_team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE journey (id INT AUTO_INCREMENT NOT NULL, championship_id INT NOT NULL, number INT NOT NULL, INDEX IDX_C816C6A294DDBCE9 (championship_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE league (id INT AUTO_INCREMENT NOT NULL, owner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, is_private TINYINT(1) NOT NULL, INDEX IDX_3EB4C3187E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player (id INT AUTO_INCREMENT NOT NULL, team_id INT NOT NULL, name VARCHAR(255) NOT NULL, number INT NOT NULL, type VARCHAR(50) NOT NULL, dead TINYINT(1) NOT NULL, INDEX IDX_98197A65296CD8AE (team_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE player_version (id INT AUTO_INCREMENT NOT NULL, player_id INT NOT NULL, characteristics LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', skills LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', injuries LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', value INT NOT NULL, dead TINYINT(1) NOT NULL, actions LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_DEE82C8699E6F5DF (player_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rule (id INT AUTO_INCREMENT NOT NULL, rule_key VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, rule LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', post_bb_2020 TINYINT(1) NOT NULL, read_only TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_46D8ACCCFD5CEC5B (rule_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE team (id INT AUTO_INCREMENT NOT NULL, coach_id INT NOT NULL, championship_id INT DEFAULT NULL, rule_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, anthem LONGTEXT DEFAULT NULL, fluff LONGTEXT DEFAULT NULL, roster VARCHAR(50) NOT NULL, rerolls INT NOT NULL, cheerleaders INT NOT NULL, assistants INT NOT NULL, popularity INT NOT NULL, apothecary TINYINT(1) NOT NULL, INDEX IDX_C4E0A61F3C105691 (coach_id), INDEX IDX_C4E0A61F94DDBCE9 (championship_id), INDEX IDX_C4E0A61F744E0351 (rule_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE championship ADD CONSTRAINT FK_EBADDE6A58AFC4DE FOREIGN KEY (league_id) REFERENCES league (id)');
        $this->addSql('ALTER TABLE championship ADD CONSTRAINT FK_EBADDE6A744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id)');
        $this->addSql('ALTER TABLE championship_manager ADD CONSTRAINT FK_CE3DF45194DDBCE9 FOREIGN KEY (championship_id) REFERENCES championship (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE championship_manager ADD CONSTRAINT FK_CE3DF4513C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE championship_coach ADD CONSTRAINT FK_307D92CD94DDBCE9 FOREIGN KEY (championship_id) REFERENCES championship (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE championship_coach ADD CONSTRAINT FK_307D92CD3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE championship_invitation ADD CONSTRAINT FK_AAA4BC1094DDBCE9 FOREIGN KEY (championship_id) REFERENCES championship (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C94DDBCE9 FOREIGN KEY (championship_id) REFERENCES championship (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CD5C9896F FOREIGN KEY (journey_id) REFERENCES journey (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318C9C4C13F6 FOREIGN KEY (home_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE game ADD CONSTRAINT FK_232B318CEB7F4866 FOREIGN KEY (visitor_team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE journey ADD CONSTRAINT FK_C816C6A294DDBCE9 FOREIGN KEY (championship_id) REFERENCES championship (id)');
        $this->addSql('ALTER TABLE league ADD CONSTRAINT FK_3EB4C3187E3C61F9 FOREIGN KEY (owner_id) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65296CD8AE FOREIGN KEY (team_id) REFERENCES team (id)');
        $this->addSql('ALTER TABLE player_version ADD CONSTRAINT FK_DEE82C8699E6F5DF FOREIGN KEY (player_id) REFERENCES player (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F3C105691 FOREIGN KEY (coach_id) REFERENCES coach (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F94DDBCE9 FOREIGN KEY (championship_id) REFERENCES championship (id)');
        $this->addSql('ALTER TABLE team ADD CONSTRAINT FK_C4E0A61F744E0351 FOREIGN KEY (rule_id) REFERENCES rule (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE championship_manager DROP FOREIGN KEY FK_CE3DF45194DDBCE9');
        $this->addSql('ALTER TABLE championship_coach DROP FOREIGN KEY FK_307D92CD94DDBCE9');
        $this->addSql('ALTER TABLE championship_invitation DROP FOREIGN KEY FK_AAA4BC1094DDBCE9');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C94DDBCE9');
        $this->addSql('ALTER TABLE journey DROP FOREIGN KEY FK_C816C6A294DDBCE9');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F94DDBCE9');
        $this->addSql('ALTER TABLE championship_manager DROP FOREIGN KEY FK_CE3DF4513C105691');
        $this->addSql('ALTER TABLE championship_coach DROP FOREIGN KEY FK_307D92CD3C105691');
        $this->addSql('ALTER TABLE league DROP FOREIGN KEY FK_3EB4C3187E3C61F9');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F3C105691');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CD5C9896F');
        $this->addSql('ALTER TABLE championship DROP FOREIGN KEY FK_EBADDE6A58AFC4DE');
        $this->addSql('ALTER TABLE player_version DROP FOREIGN KEY FK_DEE82C8699E6F5DF');
        $this->addSql('ALTER TABLE championship DROP FOREIGN KEY FK_EBADDE6A744E0351');
        $this->addSql('ALTER TABLE team DROP FOREIGN KEY FK_C4E0A61F744E0351');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318C9C4C13F6');
        $this->addSql('ALTER TABLE game DROP FOREIGN KEY FK_232B318CEB7F4866');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65296CD8AE');
        $this->addSql('DROP TABLE championship');
        $this->addSql('DROP TABLE championship_manager');
        $this->addSql('DROP TABLE championship_coach');
        $this->addSql('DROP TABLE championship_invitation');
        $this->addSql('DROP TABLE coach');
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE journey');
        $this->addSql('DROP TABLE league');
        $this->addSql('DROP TABLE player');
        $this->addSql('DROP TABLE player_version');
        $this->addSql('DROP TABLE rule');
        $this->addSql('DROP TABLE team');
    }
}
