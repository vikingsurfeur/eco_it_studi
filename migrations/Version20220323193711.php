<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323193711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD user_instructor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB962C16CC3 FOREIGN KEY (user_instructor_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB962C16CC3 ON course (user_instructor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB962C16CC3');
        $this->addSql('DROP INDEX IDX_169E6FB962C16CC3 ON course');
        $this->addSql('ALTER TABLE course DROP user_instructor_id');
    }
}
