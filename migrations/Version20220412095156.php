<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220412095156 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course DROP is_finished');
        $this->addSql('ALTER TABLE lesson DROP is_finished');
        $this->addSql('ALTER TABLE section DROP is_finished');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE course ADD is_finished TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE lesson ADD is_finished TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE section ADD is_finished TINYINT(1) NOT NULL');
    }
}
