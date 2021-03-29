<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329030953 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, category_id_id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(1000) NOT NULL, image_url VARCHAR(1000) DEFAULT NULL, content VARBINARY(255) NOT NULL, INDEX IDX_23A0E669D86650F (user_id_id), INDEX IDX_23A0E669777D11E (category_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, categories_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_497DD634A21214B7 (categories_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, admin TINYINT(1) NOT NULL, timestamp DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669777D11E FOREIGN KEY (category_id_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634A21214B7 FOREIGN KEY (categories_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669777D11E');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634A21214B7');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669D86650F');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE user');
    }
}
