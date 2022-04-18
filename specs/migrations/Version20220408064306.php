<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220408064306 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE progress_user (progress_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8D1AF98043DB87C9 (progress_id), INDEX IDX_8D1AF980A76ED395 (user_id), PRIMARY KEY(progress_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE progress_user ADD CONSTRAINT FK_8D1AF98043DB87C9 FOREIGN KEY (progress_id) REFERENCES progress (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE progress_user ADD CONSTRAINT FK_8D1AF980A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE progress_user');
    }
}
