<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220331201515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD course_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045F591CC992 ON image (course_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F591CC992');
        $this->addSql('DROP INDEX UNIQ_C53D045F591CC992 ON image');
        $this->addSql('ALTER TABLE image DROP course_id');
    }
}
