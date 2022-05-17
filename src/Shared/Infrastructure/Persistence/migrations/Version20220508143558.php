<?php

declare(strict_types=1);

namespace Shared\Infrastructure\Persistence\migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508143558 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create empty tables';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("CREATE TABLE `source_book` (
            `id` varchar(36) NOT NULL,
            `name` varchar(150) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 
        ");

        $this->addSql("CREATE TABLE `monster_type` (
            `id` varchar(36) NOT NULL,
            `type` varchar(150) NOT NULL,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 
        ");

        $this->addSql("CREATE TABLE `monster` (
            `id` varchar(36) NOT NULL,
            `name` varchar(250) NOT NULL,
            `sourcebook_id` varchar(36) DEFAULT NULL,
            `page` int,
            `type_id` varchar(36) NOT NULL,
            `size` char(1) NOT NULL,
            `cr` char(3) NOT NULL,
            `img` varchar(250) DEFAULT NULL,
            `init_bonus` int DEFAULT 0,
            `hp_avg` int,
            `hp_max` int,
            `ac` int,
            PRIMARY KEY (`id`),
            KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");

        $this->addSql("CREATE TABLE `campaign` (
            `id` varchar(36) NOT NULL,
            `name` varchar(150) NOT NULL,
            `active` TINYINT(1) DEFAULT 1,
            `created_at` DATETIME NOT NULL DEFAULT current_timestamp,
            PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 
        ");

        $this->addSql("CREATE TABLE `player_character` (
            `id` varchar(36) not null,
            `campaign_id` varchar(36) not null,
            `name` varchar(250) not null,
            `player_name` varchar(150) not null,
            `level` int DEFAULT 1,
            `ac` int,
            `hp` int,
            `speed` int DEFAULT 30,
            `img` varchar(250),
            PRIMARY KEY (`id`),
            KEY `campaign_id` (`campaign_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");

        $this->addSql("CREATE TABLE `encounter` (
            `id` varchar(36) not null,
            `campaign_id` varchar(36) not null,
            `difficulty` varchar(6) not null,
            `total_experience` int,
            `experience_per_player` int, 
            `last_updated` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            `current_round` int not null default 1,
            `current_turn` int not null default 1, 
            PRIMARY KEY (`id`),
            KEY `campaign_id` (`campaign_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");

        $this->addSql("CREATE TABLE `encounter_participant` (
            `id` varchar(36) not null,
            `encounter_id` varchar(36) not null,
            `participant_id` varchar(36) not null,
            `participant_type` enum ('C', 'M') COMMENT 'C: character - M: monster',
            `initiative_roll` int,
            `max_hp` int,
            `current_hp` int, 
            PRIMARY KEY (`id`),
            KEY `encounter_id` (`encounter_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE `source_book`");
        $this->addSql("DROP TABLE `monster_type`");
        $this->addSql("DROP TABLE `monster`");
        $this->addSql("DROP TABLE `campaign`");
        $this->addSql("DROP TABLE `character`");
        $this->addSql("DROP TABLE `encounter`");
        $this->addSql("DROP TABLE `encounter_participant`");
    }
}
