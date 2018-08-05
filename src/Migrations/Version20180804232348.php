<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180804232348 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE topics (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, author_id INT DEFAULT NULL, last_message_id INT DEFAULT NULL, date DATETIME NOT NULL, close TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_91F64639D823E37A (section_id), INDEX IDX_91F64639F675F31B (author_id), UNIQUE INDEX UNIQ_91F64639BA0E79C3 (last_message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, topics_id INT DEFAULT NULL, author_id INT DEFAULT NULL, date DATETIME NOT NULL, text LONGTEXT NOT NULL, INDEX IDX_DB021E96BF06A414 (topics_id), INDEX IDX_DB021E96F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96BF06A414');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F64639BA0E79C3');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F64639F675F31B');
        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96F675F31B');
        $this->addSql('ALTER TABLE topics DROP FOREIGN KEY FK_91F64639D823E37A');
        $this->addSql('DROP TABLE topics');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE sections');
    }
}
