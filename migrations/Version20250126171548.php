<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250126171548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add apiToken field to users table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_variant_value DROP FOREIGN KEY FK_4710DB9B1AE56DE9');
        $this->addSql('ALTER TABLE category_attribute_types DROP FOREIGN KEY FK_E28136D4319912A0');
        $this->addSql('ALTER TABLE product_variant_value DROP FOREIGN KEY FK_4710DB9B4ED0D557');
        $this->addSql('ALTER TABLE variant_attribute_option DROP FOREIGN KEY FK_5BAD62A6C54C8C93');
        $this->addSql('ALTER TABLE variant_attribute_type DROP FOREIGN KEY FK_905D52B912469DE2');
        $this->addSql('ALTER TABLE variant_attribute_value DROP FOREIGN KEY FK_ED6448751AE56DE9');
        $this->addSql('ALTER TABLE variant_attribute_value DROP FOREIGN KEY FK_ED6448753B69A9AF');
        $this->addSql('ALTER TABLE variant_attribute_value DROP FOREIGN KEY FK_ED6448754ED0D557');
        $this->addSql('ALTER TABLE variant_option DROP FOREIGN KEY FK_4FDCA766C54C8C93');
        $this->addSql('ALTER TABLE variant_value DROP FOREIGN KEY FK_9DFDC769C54C8C93');
        $this->addSql('ALTER TABLE variant_value DROP FOREIGN KEY FK_9DFDC7693B69A9AF');
        $this->addSql('ALTER TABLE variant_value DROP FOREIGN KEY FK_9DFDC769A7C41D6F');
        $this->addSql('DROP TABLE variant_attribute_option');
        $this->addSql('DROP TABLE variant_attribute_type');
        $this->addSql('DROP TABLE variant_attribute_value');
        $this->addSql('DROP TABLE variant_option');
        $this->addSql('DROP TABLE variant_type');
        $this->addSql('DROP TABLE variant_value');
        $this->addSql('ALTER TABLE cart CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE cart_item DROP quantity, DROP price');
        $this->addSql('ALTER TABLE category CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE category_attribute_types DROP FOREIGN KEY FK_E28136D412469DE2');
        $this->addSql('DROP INDEX IDX_E28136D4319912A0 ON category_attribute_types');
        $this->addSql('ALTER TABLE category_attribute_types ADD CONSTRAINT FK_E28136D412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE contact CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE `order` DROP order_number, DROP total, DROP status, DROP created_at, DROP customer_name, CHANGE province province VARCHAR(255) DEFAULT NULL, CHANGE shipping_company shipping_company VARCHAR(255) DEFAULT NULL, CHANGE payment_method payment_method VARCHAR(20) DEFAULT NULL, CHANGE payment_rate payment_rate DOUBLE PRECISION DEFAULT NULL, CHANGE paid_amount paid_amount DOUBLE PRECISION DEFAULT NULL, CHANGE payment_reference payment_reference VARCHAR(255) DEFAULT NULL, CHANGE payment_status payment_status VARCHAR(20) DEFAULT \'pending\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE product_image CHANGE is_main is_main TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE product_variant CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('DROP INDEX IDX_4710DB9B4ED0D557 ON product_variant_value');
        $this->addSql('DROP INDEX IDX_4710DB9B1AE56DE9 ON product_variant_value');
        $this->addSql('ALTER TABLE product_variant_value CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE stock_movement DROP quantity, DROP type, DROP reason, DROP created_at');
        $this->addSql('ALTER TABLE users ADD roles JSON NOT NULL, ADD api_token VARCHAR(255) DEFAULT NULL, DROP role, DROP reset_token, DROP reset_token_expiry, DROP created_at, DROP updated_at, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE users RENAME INDEX email TO UNIQ_1483A5E9E7927C74');
        $this->addSql('ALTER TABLE users ADD api_token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE variant_attribute_option (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, value VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, position INT NOT NULL, INDEX IDX_5BAD62A6C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE variant_attribute_type (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_905D52B912469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE variant_attribute_value (id INT AUTO_INCREMENT NOT NULL, variant_id INT NOT NULL, attribute_type_id INT NOT NULL, attribute_option_id INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_ED6448754ED0D557 (attribute_type_id), INDEX IDX_ED6448751AE56DE9 (attribute_option_id), INDEX IDX_ED6448753B69A9AF (variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE variant_option (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, value VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, color_code VARCHAR(7) CHARACTER SET utf8mb4 DEFAULT \'NULL\' COLLATE `utf8mb4_unicode_ci`, INDEX IDX_4FDCA766C54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE variant_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE variant_value (id INT AUTO_INCREMENT NOT NULL, variant_id INT NOT NULL, type_id INT NOT NULL, option_id INT NOT NULL, INDEX IDX_9DFDC769C54C8C93 (type_id), INDEX IDX_9DFDC769A7C41D6F (option_id), INDEX IDX_9DFDC7693B69A9AF (variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE variant_attribute_option ADD CONSTRAINT FK_5BAD62A6C54C8C93 FOREIGN KEY (type_id) REFERENCES variant_attribute_type (id)');
        $this->addSql('ALTER TABLE variant_attribute_type ADD CONSTRAINT FK_905D52B912469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE variant_attribute_value ADD CONSTRAINT FK_ED6448751AE56DE9 FOREIGN KEY (attribute_option_id) REFERENCES variant_attribute_option (id)');
        $this->addSql('ALTER TABLE variant_attribute_value ADD CONSTRAINT FK_ED6448753B69A9AF FOREIGN KEY (variant_id) REFERENCES product_variant (id)');
        $this->addSql('ALTER TABLE variant_attribute_value ADD CONSTRAINT FK_ED6448754ED0D557 FOREIGN KEY (attribute_type_id) REFERENCES variant_attribute_type (id)');
        $this->addSql('ALTER TABLE variant_option ADD CONSTRAINT FK_4FDCA766C54C8C93 FOREIGN KEY (type_id) REFERENCES variant_type (id)');
        $this->addSql('ALTER TABLE variant_value ADD CONSTRAINT FK_9DFDC769C54C8C93 FOREIGN KEY (type_id) REFERENCES variant_type (id)');
        $this->addSql('ALTER TABLE variant_value ADD CONSTRAINT FK_9DFDC7693B69A9AF FOREIGN KEY (variant_id) REFERENCES product_variant (id)');
        $this->addSql('ALTER TABLE variant_value ADD CONSTRAINT FK_9DFDC769A7C41D6F FOREIGN KEY (option_id) REFERENCES variant_option (id)');
        $this->addSql('ALTER TABLE cart CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\' COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE cart_item ADD quantity INT NOT NULL, ADD price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE category CHANGE image image VARCHAR(255) DEFAULT \'NULL\', CHANGE description description TEXT DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE category_attribute_types DROP FOREIGN KEY FK_E28136D412469DE2');
        $this->addSql('ALTER TABLE category_attribute_types ADD CONSTRAINT FK_E28136D4319912A0 FOREIGN KEY (variant_attribute_type_id) REFERENCES variant_attribute_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE category_attribute_types ADD CONSTRAINT FK_E28136D412469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_E28136D4319912A0 ON category_attribute_types (variant_attribute_type_id)');
        $this->addSql('ALTER TABLE contact CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE `order` ADD order_number VARCHAR(255) NOT NULL, ADD total DOUBLE PRECISION NOT NULL, ADD status VARCHAR(255) NOT NULL, ADD created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD customer_name VARCHAR(255) NOT NULL, CHANGE province province VARCHAR(255) DEFAULT \'NULL\', CHANGE shipping_company shipping_company VARCHAR(255) DEFAULT \'NULL\', CHANGE payment_method payment_method VARCHAR(20) DEFAULT \'NULL\', CHANGE payment_rate payment_rate DOUBLE PRECISION DEFAULT \'NULL\', CHANGE paid_amount paid_amount DOUBLE PRECISION DEFAULT \'NULL\', CHANGE payment_reference payment_reference VARCHAR(255) DEFAULT \'NULL\', CHANGE payment_status payment_status VARCHAR(20) DEFAULT \'\'\'pending\'\'\' NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product CHANGE image image VARCHAR(255) DEFAULT \'NULL\', CHANGE updated_at updated_at DATETIME DEFAULT \'NULL\'');
        $this->addSql('ALTER TABLE product_image CHANGE is_main is_main TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE product_variant CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE product_variant_value CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE updated_at updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE product_variant_value ADD CONSTRAINT FK_4710DB9B4ED0D557 FOREIGN KEY (attribute_type_id) REFERENCES variant_attribute_type (id)');
        $this->addSql('ALTER TABLE product_variant_value ADD CONSTRAINT FK_4710DB9B1AE56DE9 FOREIGN KEY (attribute_option_id) REFERENCES variant_attribute_option (id)');
        $this->addSql('CREATE INDEX IDX_4710DB9B4ED0D557 ON product_variant_value (attribute_type_id)');
        $this->addSql('CREATE INDEX IDX_4710DB9B1AE56DE9 ON product_variant_value (attribute_option_id)');
        $this->addSql('ALTER TABLE stock_movement ADD quantity INT NOT NULL, ADD type VARCHAR(20) NOT NULL, ADD reason VARCHAR(255) DEFAULT \'NULL\', ADD created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE users ADD role VARCHAR(255) DEFAULT \'NULL\', ADD reset_token VARCHAR(255) DEFAULT \'NULL\', ADD reset_token_expiry DATETIME DEFAULT \'NULL\', ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT \'current_timestamp()\', DROP roles, DROP api_token, CHANGE email email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE users RENAME INDEX uniq_1483a5e9e7927c74 TO email');
        $this->addSql('ALTER TABLE users DROP api_token');
    }
}
