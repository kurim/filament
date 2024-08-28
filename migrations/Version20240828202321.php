<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828202321 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE filament (id INT AUTO_INCREMENT NOT NULL, vendor_id INT NOT NULL, material_id INT NOT NULL, basecolor_id INT NOT NULL, qrcode VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, colorhex VARCHAR(6) NOT NULL, specs JSON NOT NULL COMMENT \'(DC2Type:json)\', image VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, INDEX IDX_9DAA3BA6F603EE73 (vendor_id), INDEX IDX_9DAA3BA6E308AC6F (material_id), INDEX IDX_9DAA3BA63A9447AC (basecolor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filament_basecolor (id INT AUTO_INCREMENT NOT NULL, color VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filament_material (id INT AUTO_INCREMENT NOT NULL, material_name VARCHAR(255) NOT NULL, material_description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE filament_vendor (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE filament ADD CONSTRAINT FK_9DAA3BA6F603EE73 FOREIGN KEY (vendor_id) REFERENCES filament_vendor (id)');
        $this->addSql('ALTER TABLE filament ADD CONSTRAINT FK_9DAA3BA6E308AC6F FOREIGN KEY (material_id) REFERENCES filament_material (id)');
        $this->addSql('ALTER TABLE filament ADD CONSTRAINT FK_9DAA3BA63A9447AC FOREIGN KEY (basecolor_id) REFERENCES filament_basecolor (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE filament DROP FOREIGN KEY FK_9DAA3BA6F603EE73');
        $this->addSql('ALTER TABLE filament DROP FOREIGN KEY FK_9DAA3BA6E308AC6F');
        $this->addSql('ALTER TABLE filament DROP FOREIGN KEY FK_9DAA3BA63A9447AC');
        $this->addSql('DROP TABLE filament');
        $this->addSql('DROP TABLE filament_basecolor');
        $this->addSql('DROP TABLE filament_material');
        $this->addSql('DROP TABLE filament_vendor');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
