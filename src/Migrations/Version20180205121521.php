<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180205121521 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offers_tlpts_included ADD CONSTRAINT FK_9602240F53C674EE FOREIGN KEY (offer_id) REFERENCES offer (offer_id)');
        $this->addSql('ALTER TABLE offers_tlpts_included ADD CONSTRAINT FK_9602240FA559B146 FOREIGN KEY (tlpt_nql) REFERENCES tlpt (nql)');
        $this->addSql('ALTER TABLE offers_tlpts_excluded ADD CONSTRAINT FK_C5A398B453C674EE FOREIGN KEY (offer_id) REFERENCES offer (offer_id)');
        $this->addSql('ALTER TABLE offers_tlpts_excluded ADD CONSTRAINT FK_C5A398B4A559B146 FOREIGN KEY (tlpt_nql) REFERENCES tlpt (nql)');
        $this->addSql('ALTER TABLE offers_tlpts_unassigned ADD CONSTRAINT FK_CF61A68D53C674EE FOREIGN KEY (offer_id) REFERENCES offer (offer_id)');
        $this->addSql('ALTER TABLE offers_tlpts_unassigned ADD CONSTRAINT FK_CF61A68DA559B146 FOREIGN KEY (tlpt_nql) REFERENCES tlpt (nql)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE offers_tlpts_excluded DROP FOREIGN KEY FK_C5A398B453C674EE');
        $this->addSql('ALTER TABLE offers_tlpts_excluded DROP FOREIGN KEY FK_C5A398B4A559B146');
        $this->addSql('ALTER TABLE offers_tlpts_included DROP FOREIGN KEY FK_9602240F53C674EE');
        $this->addSql('ALTER TABLE offers_tlpts_included DROP FOREIGN KEY FK_9602240FA559B146');
        $this->addSql('ALTER TABLE offers_tlpts_unassigned DROP FOREIGN KEY FK_CF61A68D53C674EE');
        $this->addSql('ALTER TABLE offers_tlpts_unassigned DROP FOREIGN KEY FK_CF61A68DA559B146');
    }
}
