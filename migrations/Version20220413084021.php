<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220413084021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE progress_course DROP FOREIGN KEY FK_A7773E6E43DB87C9');
        $this->addSql('ALTER TABLE progress_lesson DROP FOREIGN KEY FK_499D252443DB87C9');
        $this->addSql('ALTER TABLE progress_section DROP FOREIGN KEY FK_3575D4C943DB87C9');
        $this->addSql('ALTER TABLE progress_user DROP FOREIGN KEY FK_8D1AF98043DB87C9');
        $this->addSql('DROP TABLE progress');
        $this->addSql('DROP TABLE progress_course');
        $this->addSql('DROP TABLE progress_lesson');
        $this->addSql('DROP TABLE progress_section');
        $this->addSql('DROP TABLE progress_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE progress (id INT AUTO_INCREMENT NOT NULL, course_finished TINYINT(1) NOT NULL, section_finished TINYINT(1) NOT NULL, lesson_finished TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE progress_course (progress_id INT NOT NULL, course_id INT NOT NULL, INDEX IDX_A7773E6E591CC992 (course_id), INDEX IDX_A7773E6E43DB87C9 (progress_id), PRIMARY KEY(progress_id, course_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE progress_lesson (progress_id INT NOT NULL, lesson_id INT NOT NULL, INDEX IDX_499D2524CDF80196 (lesson_id), INDEX IDX_499D252443DB87C9 (progress_id), PRIMARY KEY(progress_id, lesson_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE progress_section (progress_id INT NOT NULL, section_id INT NOT NULL, INDEX IDX_3575D4C9D823E37A (section_id), INDEX IDX_3575D4C943DB87C9 (progress_id), PRIMARY KEY(progress_id, section_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE progress_user (progress_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8D1AF980A76ED395 (user_id), INDEX IDX_8D1AF98043DB87C9 (progress_id), PRIMARY KEY(progress_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE progress_course ADD CONSTRAINT FK_A7773E6E43DB87C9 FOREIGN KEY (progress_id) REFERENCES progress (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE progress_course ADD CONSTRAINT FK_A7773E6E591CC992 FOREIGN KEY (course_id) REFERENCES course (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE progress_lesson ADD CONSTRAINT FK_499D252443DB87C9 FOREIGN KEY (progress_id) REFERENCES progress (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE progress_lesson ADD CONSTRAINT FK_499D2524CDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE progress_section ADD CONSTRAINT FK_3575D4C943DB87C9 FOREIGN KEY (progress_id) REFERENCES progress (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE progress_section ADD CONSTRAINT FK_3575D4C9D823E37A FOREIGN KEY (section_id) REFERENCES section (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE progress_user ADD CONSTRAINT FK_8D1AF98043DB87C9 FOREIGN KEY (progress_id) REFERENCES progress (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE progress_user ADD CONSTRAINT FK_8D1AF980A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }
}
