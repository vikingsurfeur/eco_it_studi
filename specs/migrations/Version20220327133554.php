<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327133554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB962C16CC3');
        $this->addSql('DROP INDEX IDX_169E6FB962C16CC3 ON course');
        $this->addSql('ALTER TABLE course CHANGE user_instructor_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB9A76ED395 ON course (user_id)');
        $this->addSql('ALTER TABLE lesson ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lesson ADD CONSTRAINT FK_F87474F3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F87474F3A76ED395 ON lesson (user_id)');
        $this->addSql('ALTER TABLE section ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2D737AEFA76ED395 ON section (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP FOREIGN KEY FK_169E6FB9A76ED395');
        $this->addSql('DROP INDEX IDX_169E6FB9A76ED395 ON course');
        $this->addSql('ALTER TABLE course CHANGE user_id user_instructor_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE course ADD CONSTRAINT FK_169E6FB962C16CC3 FOREIGN KEY (user_instructor_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_169E6FB962C16CC3 ON course (user_instructor_id)');
        $this->addSql('ALTER TABLE lesson DROP FOREIGN KEY FK_F87474F3A76ED395');
        $this->addSql('DROP INDEX IDX_F87474F3A76ED395 ON lesson');
        $this->addSql('ALTER TABLE lesson DROP user_id');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEFA76ED395');
        $this->addSql('DROP INDEX IDX_2D737AEFA76ED395 ON section');
        $this->addSql('ALTER TABLE section DROP user_id');
    }
}
