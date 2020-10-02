<?php

declare(strict_types=1);

namespace ShowroomDoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201001084948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE car_model (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, model_name VARCHAR(40) NOT NULL, manufacturer_name VARCHAR(40) NOT NULL, class VARCHAR(1) DEFAULT NULL)');
        $this->addSql('CREATE TABLE car_price (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, car_model_id INTEGER NOT NULL, price NUMERIC(9, 2) NOT NULL, trade_in_price NUMERIC(9, 2) DEFAULT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1563A70EF64382E3 ON car_price (car_model_id)');
        $this->addSql('CREATE TABLE customer (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_account_id INTEGER NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C74404553C0C9956 ON customer (user_account_id)');
        $this->addSql('CREATE TABLE trade_in_deal (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, customer_car_model_id INTEGER NOT NULL, showroom_car_model_id INTEGER DEFAULT NULL, customer_id INTEGER NOT NULL, customer_car_price INTEGER NOT NULL, showroom_car_price INTEGER DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_3AC5A684474920E2 ON trade_in_deal (customer_car_model_id)');
        $this->addSql('CREATE INDEX IDX_3AC5A6842983E211 ON trade_in_deal (showroom_car_model_id)');
        $this->addSql('CREATE INDEX IDX_3AC5A68419EB6921 ON trade_in_deal (customer_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE car_model');
        $this->addSql('DROP TABLE car_price');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE trade_in_deal');
    }
}
