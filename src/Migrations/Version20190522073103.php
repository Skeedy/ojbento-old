<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190522073103 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE assoc DROP FOREIGN KEY FK_7B93371182A46EC6');
        $this->addSql('ALTER TABLE order_assoc DROP FOREIGN KEY FK_F80D43EC82A46EC6');
        $this->addSql('ALTER TABLE priceassoc DROP FOREIGN KEY FK_5BE4B5B082A46EC6');
        $this->addSql('ALTER TABLE assoc DROP FOREIGN KEY FK_7B933711CCD7E912');
        $this->addSql('ALTER TABLE order_menu DROP FOREIGN KEY FK_30F40084CCD7E912');
        $this->addSql('ALTER TABLE pricemenu DROP FOREIGN KEY FK_650228E6CCD7E912');
        $this->addSql('ALTER TABLE order_assoc DROP FOREIGN KEY FK_F80D43EC8D9F6D38');
        $this->addSql('ALTER TABLE order_menu DROP FOREIGN KEY FK_30F400848D9F6D38');
        $this->addSql('ALTER TABLE priceassoc DROP FOREIGN KEY FK_5BE4B5B0C54C8C93');
        $this->addSql('ALTER TABLE pricemenu DROP FOREIGN KEY FK_650228E6C54C8C93');
        $this->addSql('DROP TABLE assoc');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_assoc');
        $this->addSql('DROP TABLE order_menu');
        $this->addSql('DROP TABLE priceassoc');
        $this->addSql('DROP TABLE pricemenu');
        $this->addSql('DROP TABLE pricetype');
        $this->addSql('ALTER TABLE image CHANGE path path VARCHAR(255) NOT NULL, CHANGE imgpath imgpath VARCHAR(255) NOT NULL, CHANGE alt alt VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE fos_user DROP fname, DROP lname, DROP phone, DROP ville');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE assoc (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, menu_id INT DEFAULT NULL, assoc_id INT DEFAULT NULL, image_id INT NOT NULL, quantity INT NOT NULL, is_dish TINYINT(1) NOT NULL, INDEX IDX_7B933711CCD7E912 (menu_id), UNIQUE INDEX UNIQ_7B9337114584665A (product_id), UNIQUE INDEX UNIQ_7B9337113DA5256D (image_id), INDEX IDX_7B93371182A46EC6 (assoc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, midi TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, hour DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_assoc (order_id INT NOT NULL, assoc_id INT NOT NULL, INDEX IDX_F80D43EC8D9F6D38 (order_id), INDEX IDX_F80D43EC82A46EC6 (assoc_id), PRIMARY KEY(order_id, assoc_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE order_menu (order_id INT NOT NULL, menu_id INT NOT NULL, INDEX IDX_30F400848D9F6D38 (order_id), INDEX IDX_30F40084CCD7E912 (menu_id), PRIMARY KEY(order_id, menu_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE priceassoc (id INT AUTO_INCREMENT NOT NULL, assoc_id INT NOT NULL, type_id INT NOT NULL, value NUMERIC(5, 2) NOT NULL, INDEX IDX_5BE4B5B0C54C8C93 (type_id), INDEX IDX_5BE4B5B082A46EC6 (assoc_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pricemenu (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, menu_id INT NOT NULL, value NUMERIC(5, 2) NOT NULL, INDEX IDX_650228E6CCD7E912 (menu_id), INDEX IDX_650228E6C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE pricetype (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE assoc ADD CONSTRAINT FK_7B9337113DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE assoc ADD CONSTRAINT FK_7B9337114584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE assoc ADD CONSTRAINT FK_7B93371182A46EC6 FOREIGN KEY (assoc_id) REFERENCES assoc (id)');
        $this->addSql('ALTER TABLE assoc ADD CONSTRAINT FK_7B933711CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE order_assoc ADD CONSTRAINT FK_F80D43EC82A46EC6 FOREIGN KEY (assoc_id) REFERENCES assoc (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_assoc ADD CONSTRAINT FK_F80D43EC8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_menu ADD CONSTRAINT FK_30F400848D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_menu ADD CONSTRAINT FK_30F40084CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE priceassoc ADD CONSTRAINT FK_5BE4B5B082A46EC6 FOREIGN KEY (assoc_id) REFERENCES assoc (id)');
        $this->addSql('ALTER TABLE priceassoc ADD CONSTRAINT FK_5BE4B5B0C54C8C93 FOREIGN KEY (type_id) REFERENCES pricetype (id)');
        $this->addSql('ALTER TABLE pricemenu ADD CONSTRAINT FK_650228E6C54C8C93 FOREIGN KEY (type_id) REFERENCES pricetype (id)');
        $this->addSql('ALTER TABLE pricemenu ADD CONSTRAINT FK_650228E6CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE fos_user ADD fname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD lname VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD phone VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD ville VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE image CHANGE imgpath imgpath VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE path path VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE alt alt VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
