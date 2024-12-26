<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241224163656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE creneau_horaire');
        $this->addSql('ALTER TABLE matieres ADD nb_minutes INT NOT NULL, CHANGE nb_heure duree_minute INT NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD enseignant_id INT NOT NULL, ADD promotion_id INT NOT NULL, ADD matiere_id INT NOT NULL, ADD salle_id INT NOT NULL, ADD date DATE NOT NULL, ADD heure_debut TIME NOT NULL, ADD heure_fin TIME NOT NULL');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239E455FCC0 FOREIGN KEY (enseignant_id) REFERENCES enseignants (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239139DF194 FOREIGN KEY (promotion_id) REFERENCES promotions (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239F46CD258 FOREIGN KEY (matiere_id) REFERENCES matieres (id)');
        $this->addSql('ALTER TABLE reservations ADD CONSTRAINT FK_4DA239DC304035 FOREIGN KEY (salle_id) REFERENCES salles (id)');
        $this->addSql('CREATE INDEX IDX_4DA239E455FCC0 ON reservations (enseignant_id)');
        $this->addSql('CREATE INDEX IDX_4DA239139DF194 ON reservations (promotion_id)');
        $this->addSql('CREATE INDEX IDX_4DA239F46CD258 ON reservations (matiere_id)');
        $this->addSql('CREATE INDEX IDX_4DA239DC304035 ON reservations (salle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE creneau_horaire (id INT AUTO_INCREMENT NOT NULL, date_creneau DATE NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE matieres ADD nb_heure INT NOT NULL, DROP duree_minute, DROP nb_minutes');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239E455FCC0');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239139DF194');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239F46CD258');
        $this->addSql('ALTER TABLE reservations DROP FOREIGN KEY FK_4DA239DC304035');
        $this->addSql('DROP INDEX IDX_4DA239E455FCC0 ON reservations');
        $this->addSql('DROP INDEX IDX_4DA239139DF194 ON reservations');
        $this->addSql('DROP INDEX IDX_4DA239F46CD258 ON reservations');
        $this->addSql('DROP INDEX IDX_4DA239DC304035 ON reservations');
        $this->addSql('ALTER TABLE reservations DROP enseignant_id, DROP promotion_id, DROP matiere_id, DROP salle_id, DROP date, DROP heure_debut, DROP heure_fin');
    }
}
