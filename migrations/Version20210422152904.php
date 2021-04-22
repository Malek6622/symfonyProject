<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422152904 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD64E7214B');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD64E7214B FOREIGN KEY (department_id_id) REFERENCES department (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD64E7214B');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD64E7214B FOREIGN KEY (department_id_id) REFERENCES department (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
