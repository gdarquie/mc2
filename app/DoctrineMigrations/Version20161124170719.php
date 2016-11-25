<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161124170719 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE disc_has_person');
        $this->addSql('ALTER TABLE studio ADD date_creation DATETIME NOT NULL, ADD last_update DATETIME NOT NULL');
        $this->addSql('ALTER TABLE thesaurus ADD code VARCHAR(255) NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE disc_has_person (profession_id INT NOT NULL, person_id INT NOT NULL, disc_id INT NOT NULL, INDEX fk_disc_has_person_person1_idx (person_id), INDEX fk_disc_has_person_disc1_idx (disc_id), INDEX fk_disc_has_person_profession1_idx (profession_id), PRIMARY KEY(profession_id, person_id, disc_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE disc_has_person ADD CONSTRAINT fk_disc_has_person_disc1 FOREIGN KEY (disc_id) REFERENCES disc (disc_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE disc_has_person ADD CONSTRAINT fk_disc_has_person_person1 FOREIGN KEY (person_id) REFERENCES person (person_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE disc_has_person ADD CONSTRAINT fk_disc_has_person_profession1 FOREIGN KEY (profession_id) REFERENCES profession (profession_id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE studio DROP date_creation, DROP last_update');
        $this->addSql('ALTER TABLE thesaurus DROP code');
    }
}
