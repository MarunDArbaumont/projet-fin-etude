<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415104621 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user_manga (user_id INT NOT NULL, manga_id INT NOT NULL, INDEX IDX_9498655BA76ED395 (user_id), INDEX IDX_9498655B7B6461 (manga_id), PRIMARY KEY(user_id, manga_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_manga ADD CONSTRAINT FK_9498655BA76ED395 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_manga ADD CONSTRAINT FK_9498655B7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE user_manga DROP FOREIGN KEY FK_9498655BA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user_manga DROP FOREIGN KEY FK_9498655B7B6461
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user_manga
        SQL);
    }
}
