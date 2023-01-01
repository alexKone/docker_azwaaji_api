<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230101203313 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stripe_subscription DROP FOREIGN KEY FK_6F290B43A76ED395');
        $this->addSql('DROP INDEX IDX_6F290B43A76ED395 ON stripe_subscription');
        $this->addSql('ALTER TABLE stripe_subscription ADD profile_id INT DEFAULT NULL, DROP user_id');
        $this->addSql('ALTER TABLE stripe_subscription ADD CONSTRAINT FK_6F290B43CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id)');
        $this->addSql('CREATE INDEX IDX_6F290B43CCFA12B8 ON stripe_subscription (profile_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stripe_subscription DROP FOREIGN KEY FK_6F290B43CCFA12B8');
        $this->addSql('DROP INDEX IDX_6F290B43CCFA12B8 ON stripe_subscription');
        $this->addSql('ALTER TABLE stripe_subscription ADD user_id INT NOT NULL, DROP profile_id');
        $this->addSql('ALTER TABLE stripe_subscription ADD CONSTRAINT FK_6F290B43A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_6F290B43A76ED395 ON stripe_subscription (user_id)');
    }
}
