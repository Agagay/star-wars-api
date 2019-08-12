<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190808211822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Add relation to Planet and People';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE planet_people (planet_id INT NOT NULL, people_id INT NOT NULL, INDEX IDX_B40B6FEEA25E9820 (planet_id), INDEX IDX_B40B6FEE3147C936 (people_id), PRIMARY KEY(planet_id, people_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE planet_people ADD CONSTRAINT FK_B40B6FEEA25E9820 FOREIGN KEY (planet_id) REFERENCES planet (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE planet_people ADD CONSTRAINT FK_B40B6FEE3147C936 FOREIGN KEY (people_id) REFERENCES people (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE planet_people');
    }
}
