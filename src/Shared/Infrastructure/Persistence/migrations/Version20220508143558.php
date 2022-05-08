<?php

declare(strict_types=1);

namespace DoctrineMigrations;

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
        $this->addSql("CREATE TABLE `sourcebook` (
              `id` varchar(36) NOT NULL,
              `name` varchar(250) DEFAULT NULL,
              `abbr` varchar(100) DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
        ");

        $this->addSql("CREATE TABLE `monster` (
              `id` varchar(36) NOT NULL,
              `name` varchar(250) DEFAULT NULL,
              `source_book` varchar(36) DEFAULT NULL,
              `page` int DEFAULT NULL,
              `cr` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
              PRIMARY KEY (`id`),
              KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
        ");
    }

    public function down(Schema $schema): void
    {
        $this->addSql("DROP TABLE `sourcebook`");
        $this->addSql("DROP TABLE `monster`");
    }
}
