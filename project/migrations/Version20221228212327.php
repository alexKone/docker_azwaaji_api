<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221228212327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conversation_participant (conversation_id INT NOT NULL, profile_id INT NOT NULL, INDEX IDX_398016619AC0396 (conversation_id), INDEX IDX_39801661CCFA12B8 (profile_id), PRIMARY KEY(conversation_id, profile_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE conversation_participant ADD CONSTRAINT FK_398016619AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation_participant ADD CONSTRAINT FK_39801661CCFA12B8 FOREIGN KEY (profile_id) REFERENCES profile (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE conversation ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FCD53EDB6');
        $this->addSql('DROP INDEX IDX_B6BD307FCD53EDB6 ON message');
        $this->addSql('ALTER TABLE message ADD updated_at DATETIME NOT NULL, CHANGE sender_id sender_id INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE receiver_id conversation_id INT DEFAULT NULL, CHANGE message content LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F9AC0396 FOREIGN KEY (conversation_id) REFERENCES conversation (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F9AC0396 ON message (conversation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE conversation_participant DROP FOREIGN KEY FK_398016619AC0396');
        $this->addSql('ALTER TABLE conversation_participant DROP FOREIGN KEY FK_39801661CCFA12B8');
        $this->addSql('DROP TABLE conversation_participant');
        $this->addSql('ALTER TABLE conversation DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F9AC0396');
        $this->addSql('DROP INDEX IDX_B6BD307F9AC0396 ON message');
        $this->addSql('ALTER TABLE message DROP updated_at, CHANGE sender_id sender_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE conversation_id receiver_id INT DEFAULT NULL, CHANGE content message LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES profile (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_B6BD307FCD53EDB6 ON message (receiver_id)');
    }
}
