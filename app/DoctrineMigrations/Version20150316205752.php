<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150316205752 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE User (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, username_canonical VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, email_canonical VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, locked TINYINT(1) NOT NULL, expired TINYINT(1) NOT NULL, expires_at DATETIME DEFAULT NULL, confirmation_token VARCHAR(255) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', credentials_expired TINYINT(1) NOT NULL, credentials_expire_at DATETIME DEFAULT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) DEFAULT NULL, company VARCHAR(255) DEFAULT NULL, bio LONGTEXT DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, website VARCHAR(255) DEFAULT NULL, facebook VARCHAR(255) DEFAULT NULL, twitter VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_2DA1797792FC23A8 (username_canonical), UNIQUE INDEX UNIQ_2DA17977A0D96FBF (email_canonical), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE File (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) DEFAULT NULL, size INT DEFAULT NULL, token VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Image (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Whitepaper (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, file_id INT DEFAULT NULL, image_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, lang VARCHAR(10) DEFAULT NULL, published_on DATE NOT NULL, published TINYINT(1) NOT NULL, updated_at DATETIME DEFAULT NULL, slug VARCHAR(128) NOT NULL, UNIQUE INDEX UNIQ_587B90B1989D9B62 (slug), INDEX IDX_587B90B1A76ED395 (user_id), UNIQUE INDEX UNIQ_587B90B193CB796C (file_id), UNIQUE INDEX UNIQ_587B90B13DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE Whitepaper ADD CONSTRAINT FK_587B90B1A76ED395 FOREIGN KEY (user_id) REFERENCES User (id)');
        $this->addSql('ALTER TABLE Whitepaper ADD CONSTRAINT FK_587B90B193CB796C FOREIGN KEY (file_id) REFERENCES File (id)');
        $this->addSql('ALTER TABLE Whitepaper ADD CONSTRAINT FK_587B90B13DA5256D FOREIGN KEY (image_id) REFERENCES Image (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE Whitepaper DROP FOREIGN KEY FK_587B90B1A76ED395');
        $this->addSql('ALTER TABLE Whitepaper DROP FOREIGN KEY FK_587B90B193CB796C');
        $this->addSql('ALTER TABLE Whitepaper DROP FOREIGN KEY FK_587B90B13DA5256D');
        $this->addSql('DROP TABLE User');
        $this->addSql('DROP TABLE File');
        $this->addSql('DROP TABLE Image');
        $this->addSql('DROP TABLE Whitepaper');
    }
}
