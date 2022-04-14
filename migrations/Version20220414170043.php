<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414170043 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, created_by_id INT DEFAULT NULL, section_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A412FA92B03A8386 (created_by_id), UNIQUE INDEX UNIQ_A412FA92D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_answer_choice (id INT AUTO_INCREMENT NOT NULL, quiz_questions_id INT DEFAULT NULL, choice_description LONGTEXT NOT NULL, is_correct_answer TINYINT(1) NOT NULL, INDEX IDX_19EBB2246A48B135 (quiz_questions_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_question (id INT AUTO_INCREMENT NOT NULL, question_description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz_question_quiz (quiz_question_id INT NOT NULL, quiz_id INT NOT NULL, INDEX IDX_D045C56C3101E51F (quiz_question_id), INDEX IDX_D045C56C853CD175 (quiz_id), PRIMARY KEY(quiz_question_id, quiz_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_quiz_result (id INT AUTO_INCREMENT NOT NULL, is_resolved_by_id INT DEFAULT NULL, quiz_id INT DEFAULT NULL, nb_good_answer INT NOT NULL, answered_at DATETIME NOT NULL, is_resolved TINYINT(1) NOT NULL, INDEX IDX_5735F8DF41ABD8C6 (is_resolved_by_id), INDEX IDX_5735F8DF853CD175 (quiz_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92D823E37A FOREIGN KEY (section_id) REFERENCES section (id)');
        $this->addSql('ALTER TABLE quiz_answer_choice ADD CONSTRAINT FK_19EBB2246A48B135 FOREIGN KEY (quiz_questions_id) REFERENCES quiz_question (id)');
        $this->addSql('ALTER TABLE quiz_question_quiz ADD CONSTRAINT FK_D045C56C3101E51F FOREIGN KEY (quiz_question_id) REFERENCES quiz_question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE quiz_question_quiz ADD CONSTRAINT FK_D045C56C853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_quiz_result ADD CONSTRAINT FK_5735F8DF41ABD8C6 FOREIGN KEY (is_resolved_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_quiz_result ADD CONSTRAINT FK_5735F8DF853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE section ADD quiz_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF853CD175 FOREIGN KEY (quiz_id) REFERENCES quiz (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D737AEF853CD175 ON section (quiz_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_question_quiz DROP FOREIGN KEY FK_D045C56C853CD175');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF853CD175');
        $this->addSql('ALTER TABLE user_quiz_result DROP FOREIGN KEY FK_5735F8DF853CD175');
        $this->addSql('ALTER TABLE quiz_answer_choice DROP FOREIGN KEY FK_19EBB2246A48B135');
        $this->addSql('ALTER TABLE quiz_question_quiz DROP FOREIGN KEY FK_D045C56C3101E51F');
        $this->addSql('DROP TABLE quiz');
        $this->addSql('DROP TABLE quiz_answer_choice');
        $this->addSql('DROP TABLE quiz_question');
        $this->addSql('DROP TABLE quiz_question_quiz');
        $this->addSql('DROP TABLE user_quiz_result');
        $this->addSql('DROP INDEX UNIQ_2D737AEF853CD175 ON section');
        $this->addSql('ALTER TABLE section DROP quiz_id');
    }
}
