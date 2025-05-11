<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511110551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE animal CHANGE animal_gender animal_gender VARCHAR(255) DEFAULT NULL, CHANGE animal_age animal_age INT DEFAULT NULL, CHANGE animal_cage animal_cage INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket CHANGE ticket_date ticket_date VARCHAR(255) DEFAULT NULL, CHANGE ticket_time ticket_time VARCHAR(255) DEFAULT NULL, CHANGE ticket_cost ticket_cost DOUBLE PRECISION DEFAULT NULL, CHANGE user_email user_email VARCHAR(255) DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user CHANGE user_name user_name VARCHAR(255) DEFAULT NULL, CHANGE user_role user_role JSON NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX UNIQ_8D93D649550872C ON user (user_email)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP INDEX UNIQ_8D93D649550872C ON user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user CHANGE user_name user_name VARCHAR(255) NOT NULL, CHANGE user_role user_role VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE ticket CHANGE ticket_date ticket_date VARCHAR(255) NOT NULL, CHANGE ticket_time ticket_time VARCHAR(255) NOT NULL, CHANGE ticket_cost ticket_cost DOUBLE PRECISION NOT NULL, CHANGE user_email user_email VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE animal CHANGE animal_gender animal_gender VARCHAR(255) NOT NULL, CHANGE animal_age animal_age INT NOT NULL, CHANGE animal_cage animal_cage INT NOT NULL
        SQL);
    }
}
