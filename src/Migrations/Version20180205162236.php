<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180205162236 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE make (nql VARCHAR(255) NOT NULL, make_slug VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(nql)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user CHANGE makes make_slugs TINYTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\'');
        $this->addSql('ALTER TABLE offer CHANGE make make_slug VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE make');
        $this->addSql('ALTER TABLE offer CHANGE make_slug make VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
        $this->addSql('ALTER TABLE user CHANGE make_slugs makes TINYTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:simple_array)\'');
    }
}
