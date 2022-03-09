<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220309140831 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, job_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, cost INT NOT NULL, hired DATE NOT NULL, INDEX IDX_F804D3B9BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(2500) NOT NULL, cost INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE worktime (id INT AUTO_INCREMENT NOT NULL, employe_id INT NOT NULL, projet_id INT NOT NULL, time INT NOT NULL, INDEX IDX_5891D6231B65292 (employe_id), INDEX IDX_5891D623C18272 (projet_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B9BE04EA9 FOREIGN KEY (job_id) REFERENCES metier (id)');
        $this->addSql('ALTER TABLE worktime ADD CONSTRAINT FK_5891D6231B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE worktime ADD CONSTRAINT FK_5891D623C18272 FOREIGN KEY (projet_id) REFERENCES project (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE worktime DROP FOREIGN KEY FK_5891D6231B65292');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B9BE04EA9');
        $this->addSql('ALTER TABLE worktime DROP FOREIGN KEY FK_5891D623C18272');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE project');
        $this->addSql('DROP TABLE worktime');
    }
}
