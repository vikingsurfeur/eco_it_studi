<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414180158 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_answer_choice ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz_answer_choice ADD CONSTRAINT FK_19EBB224B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_19EBB224B03A8386 ON quiz_answer_choice (created_by_id)');
        $this->addSql('ALTER TABLE quiz_question ADD created_by_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE quiz_question ADD CONSTRAINT FK_6033B00BB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_6033B00BB03A8386 ON quiz_question (created_by_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quiz_answer_choice DROP FOREIGN KEY FK_19EBB224B03A8386');
        $this->addSql('DROP INDEX IDX_19EBB224B03A8386 ON quiz_answer_choice');
        $this->addSql('ALTER TABLE quiz_answer_choice DROP created_by_id');
        $this->addSql('ALTER TABLE quiz_question DROP FOREIGN KEY FK_6033B00BB03A8386');
        $this->addSql('DROP INDEX IDX_6033B00BB03A8386 ON quiz_question');
        $this->addSql('ALTER TABLE quiz_question DROP created_by_id');
    }
}
