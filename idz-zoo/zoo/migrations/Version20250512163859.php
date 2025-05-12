<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250512163859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE animal ADD care_id INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FF270FD45 FOREIGN KEY (care_id) REFERENCES care (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_6AAB231FF270FD45 ON animal (care_id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FF270FD45
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_6AAB231FF270FD45 ON animal
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE animal DROP care_id
        SQL);
    }
}
