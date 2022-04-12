<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412174515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE course_progress_state (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, course_id INT DEFAULT NULL, state TINYINT(1) NOT NULL, INDEX IDX_BEE7C6F4A76ED395 (user_id), INDEX IDX_BEE7C6F4591CC992 (course_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE lesson_progress_state (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, lesson_id INT DEFAULT NULL, state TINYINT(1) NOT NULL, INDEX IDX_FFB8E87A76ED395 (user_id), INDEX IDX_FFB8E87CDF80196 (lesson_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section_progress_state (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, section_id INT DEFAULT NULL, state TINYINT(1) NOT NULL, INDEX IDX_7C9BA908A76ED395 (user_id), INDEX IDX_7C9BA908D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE course_progress_state ADD CONSTRAINT FK_BEE7C6F4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE course_progress_state ADD CONSTRAINT FK_BEE7C6F4591CC992 FOREIGN KEY (course_id) REFERENCES course (id)');
        $this->addSql('ALTER TABLE lesson_progress_state ADD CONSTRAINT FK_FFB8E87A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE lesson_progress_state ADD CONSTRAINT FK_FFB8E87CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('ALTER TABLE section_progress_state ADD CONSTRAINT FK_7C9BA908A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE section_progress_state ADD CONSTRAINT FK_7C9BA908D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE course_progress_state');
        $this->addSql('DROP TABLE lesson_progress_state');
        $this->addSql('DROP TABLE section_progress_state');
    }
}
