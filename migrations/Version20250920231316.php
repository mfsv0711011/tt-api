<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250920231316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE answer (id INT AUTO_INCREMENT NOT NULL, submission_id INT DEFAULT NULL, question_id INT NOT NULL, answer_option_id INT NOT NULL, INDEX IDX_DADD4A25E1FD4933 (submission_id), INDEX IDX_DADD4A251E27F6BF (question_id), INDEX IDX_DADD4A259A3BC2B9 (answer_option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE answer_option (id INT AUTO_INCREMENT NOT NULL, label JSON NOT NULL COMMENT '(DC2Type:json)', value VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE company (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE media_object (id INT AUTO_INCREMENT NOT NULL, file_path VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE organization (id INT AUTO_INCREMENT NOT NULL, logo_id INT DEFAULT NULL, company_id INT NOT NULL, name JSON NOT NULL COMMENT '(DC2Type:json)', negative_count INT NOT NULL, positive_count INT NOT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_C1EE637CF98F144A (logo_id), INDEX IDX_C1EE637C979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE question (id INT AUTO_INCREMENT NOT NULL, text JSON NOT NULL COMMENT '(DC2Type:json)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE submission (id INT AUTO_INCREMENT NOT NULL, survey_id INT NOT NULL, organization_id INT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_DB055AF3B3FE509D (survey_id), INDEX IDX_DB055AF332C8A3DE (organization_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE survey (id INT AUTO_INCREMENT NOT NULL, title JSON NOT NULL COMMENT '(DC2Type:json)', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE survey_question (survey_id INT NOT NULL, question_id INT NOT NULL, INDEX IDX_EA000F69B3FE509D (survey_id), INDEX IDX_EA000F691E27F6BF (question_id), PRIMARY KEY(survey_id, question_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, updated_by_id INT DEFAULT NULL, deleted_by_id INT DEFAULT NULL, company_id INT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT '(DC2Type:array)', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, deleted_at DATETIME DEFAULT NULL, INDEX IDX_8D93D649896DBBDE (updated_by_id), INDEX IDX_8D93D649C76F1F52 (deleted_by_id), UNIQUE INDEX UNIQ_8D93D649979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25E1FD4933 FOREIGN KEY (submission_id) REFERENCES submission (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES question (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE answer ADD CONSTRAINT FK_DADD4A259A3BC2B9 FOREIGN KEY (answer_option_id) REFERENCES answer_option (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organization ADD CONSTRAINT FK_C1EE637CF98F144A FOREIGN KEY (logo_id) REFERENCES media_object (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organization ADD CONSTRAINT FK_C1EE637C979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE submission ADD CONSTRAINT FK_DB055AF3B3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE submission ADD CONSTRAINT FK_DB055AF332C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE survey_question ADD CONSTRAINT FK_EA000F69B3FE509D FOREIGN KEY (survey_id) REFERENCES survey (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE survey_question ADD CONSTRAINT FK_EA000F691E27F6BF FOREIGN KEY (question_id) REFERENCES question (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649896DBBDE FOREIGN KEY (updated_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD CONSTRAINT FK_8D93D649979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25E1FD4933
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A251E27F6BF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A259A3BC2B9
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organization DROP FOREIGN KEY FK_C1EE637CF98F144A
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organization DROP FOREIGN KEY FK_C1EE637C979B1AD6
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE submission DROP FOREIGN KEY FK_DB055AF3B3FE509D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE submission DROP FOREIGN KEY FK_DB055AF332C8A3DE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE survey_question DROP FOREIGN KEY FK_EA000F69B3FE509D
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE survey_question DROP FOREIGN KEY FK_EA000F691E27F6BF
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649896DBBDE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649C76F1F52
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP FOREIGN KEY FK_8D93D649979B1AD6
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE answer
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE answer_option
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE company
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE media_object
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE organization
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE question
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE submission
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE survey
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE survey_question
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
    }
}
