<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412173843 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE progress_state');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE progress_state (id INT AUTO_INCREMENT NOT NULL, course_id INT DEFAULT NULL, section_id INT DEFAULT NULL, lesson_id INT DEFAULT NULL, state TINYINT(1) NOT NULL, INDEX IDX_412B21C0D823E37A (section_id), INDEX IDX_412B21C0CDF80196 (lesson_id), INDEX IDX_412B21C0591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE progress_state ADD CONSTRAINT FK_412B21C0591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE progress_state ADD CONSTRAINT FK_412B21C0D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE progress_state ADD CONSTRAINT FK_412B21C0CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
    }
}
