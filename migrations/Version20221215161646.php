<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221215161646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question ADD lesson_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD questionText VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE question CHANGE questionText question_text VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494ECDF80196 FOREIGN KEY (lesson_id) REFERENCES lesson (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494ECDF80196 ON question (lesson_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494ECDF80196');
        $this->addSql('DROP INDEX IDX_B6F7494ECDF80196 ON question');
        $this->addSql('ALTER TABLE question DROP lesson_id');
        $this->addSql('ALTER TABLE question DROP questionText');
        $this->addSql('ALTER TABLE question CHANGE question_text questionText VARCHAR(255) NOT NULL');
    }
}
