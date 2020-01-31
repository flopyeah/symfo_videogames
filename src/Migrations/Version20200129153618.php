<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200129153618 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE console (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeu_video (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, date_sortie DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jeu_video_console (jeu_video_id INT NOT NULL, console_id INT NOT NULL, INDEX IDX_53E052AE695B6720 (jeu_video_id), INDEX IDX_53E052AE72F9DD9F (console_id), PRIMARY KEY(jeu_video_id, console_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE jeu_video_console ADD CONSTRAINT FK_53E052AE695B6720 FOREIGN KEY (jeu_video_id) REFERENCES jeu_video (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE jeu_video_console ADD CONSTRAINT FK_53E052AE72F9DD9F FOREIGN KEY (console_id) REFERENCES console (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jeu_video_console DROP FOREIGN KEY FK_53E052AE72F9DD9F');
        $this->addSql('ALTER TABLE jeu_video_console DROP FOREIGN KEY FK_53E052AE695B6720');
        $this->addSql('DROP TABLE console');
        $this->addSql('DROP TABLE jeu_video');
        $this->addSql('DROP TABLE jeu_video_console');
    }
}
