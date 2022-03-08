<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308145934 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, job_id INT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, cost INT NOT NULL, hired DATE NOT NULL, INDEX IDX_F804D3B9BE04EA9 (job_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe_project (employe_id INT NOT NULL, project_id INT NOT NULL, INDEX IDX_EBBCBC4D1B65292 (employe_id), INDEX IDX_EBBCBC4D166D1F9C (project_id), PRIMARY KEY(employe_id, project_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE project (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, price INT NOT NULL, created_at DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B9BE04EA9 FOREIGN KEY (job_id) REFERENCES metier (id)');
        $this->addSql('ALTER TABLE employe_project ADD CONSTRAINT FK_EBBCBC4D1B65292 FOREIGN KEY (employe_id) REFERENCES employe (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employe_project ADD CONSTRAINT FK_EBBCBC4D166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe_project DROP FOREIGN KEY FK_EBBCBC4D1B65292');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B9BE04EA9');
        $this->addSql('ALTER TABLE employe_project DROP FOREIGN KEY FK_EBBCBC4D166D1F9C');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE employe_project');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE project');
    }
}
