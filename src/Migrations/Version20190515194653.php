<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190515194653 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE menu_assoc');
        $this->addSql('ALTER TABLE allergen ADD CONSTRAINT FK_25BF08CE3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_25BF08CE3DA5256D ON allergen (image_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE menu_assoc (menu_id INT NOT NULL, assoc_id INT NOT NULL, INDEX IDX_EA3F1476CCD7E912 (menu_id), INDEX IDX_EA3F147682A46EC6 (assoc_id), PRIMARY KEY(menu_id, assoc_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE menu_assoc ADD CONSTRAINT FK_EA3F147682A46EC6 FOREIGN KEY (assoc_id) REFERENCES assoc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_assoc ADD CONSTRAINT FK_EA3F1476CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE allergen DROP FOREIGN KEY FK_25BF08CE3DA5256D');
        $this->addSql('DROP INDEX UNIQ_25BF08CE3DA5256D ON allergen');
    }
}
