<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190515204514 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE assoc DROP FOREIGN KEY FK_7B9337113DA5256D');
        $this->addSql('DROP INDEX UNIQ_7B9337113DA5256D ON assoc');
        $this->addSql('ALTER TABLE assoc DROP image_id');
        $this->addSql('ALTER TABLE allergen DROP FOREIGN KEY FK_25BF08CE3DA5256D');
        $this->addSql('DROP INDEX UNIQ_25BF08CE3DA5256D ON allergen');
        $this->addSql('ALTER TABLE allergen DROP image_id');
        $this->addSql('ALTER TABLE image CHANGE alt alt VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE allergen ADD image_id INT NOT NULL');
        $this->addSql('ALTER TABLE allergen ADD CONSTRAINT FK_25BF08CE3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_25BF08CE3DA5256D ON allergen (image_id)');
        $this->addSql('ALTER TABLE assoc ADD image_id INT NOT NULL');
        $this->addSql('ALTER TABLE assoc ADD CONSTRAINT FK_7B9337113DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_7B9337113DA5256D ON assoc (image_id)');
        $this->addSql('ALTER TABLE image CHANGE alt alt VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}