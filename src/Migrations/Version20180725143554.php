<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180725143554 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, topics_id INT DEFAULT NULL, date DATETIME NOT NULL, text LONGTEXT NOT NULL, author VARCHAR(255) NOT NULL, INDEX IDX_DB021E96BF06A414 (topics_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE topics (id INT AUTO_INCREMENT NOT NULL, section_id INT DEFAULT NULL, date DATETIME NOT NULL, close TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, last_post VARCHAR(255) NOT NULL, last_update DATETIME NOT NULL, INDEX IDX_91F64639D823E37A (section_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE messages ADD CONSTRAINT FK_DB021E96BF06A414 FOREIGN KEY (topics_id) REFERENCES topics (id)');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F64639D823E37A FOREIGN KEY (section_id) REFERENCES sections (id)');
        $this->addSql('ALTER TABLE topics ADD CONSTRAINT FK_91F64639D823E37A FOREIGN KEY (section_id) REFERENCES sections (id)');
        $this->addSql('INSERT INTO `sections`(`name`) VALUES (\'Авто\'),(\'ИТ\'),(\'Кино\'),(\'Музыка\'),(\'Бизнес\')');

    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96BF06A414');
        $this->addSql('DROP TABLE messages');
        $this->addSql('DROP TABLE topics');
    }
}
