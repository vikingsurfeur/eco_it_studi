<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220323200622 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document ADD lesson_id INT NOT NULL');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_D8698A76CDF80196 ON document (lesson_id)');
        $this->addSql('ALTER TABLE image ADD lesson_id INT NOT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FCDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_C53D045FCDF80196 ON image (lesson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76CDF80196');
        $this->addSql('DROP INDEX IDX_D8698A76CDF80196 ON document');
        $this->addSql('ALTER TABLE document DROP lesson_id');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FCDF80196');
        $this->addSql('DROP INDEX IDX_C53D045FCDF80196 ON image');
        $this->addSql('ALTER TABLE image DROP lesson_id');
    }
}
