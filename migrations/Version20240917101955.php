<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240917101955 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE moods (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movie_playlists (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_CDD318699D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE movies (id INT AUTO_INCREMENT NOT NULL, tmdb_id INT NOT NULL, title VARCHAR(255) NOT NULL, release_date DATE NOT NULL, overview LONGTEXT DEFAULT NULL, poster_path VARCHAR(255) DEFAULT NULL, rating_average DOUBLE PRECISION DEFAULT NULL, rating_count INT DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE playlist_movies (id INT AUTO_INCREMENT NOT NULL, playlist_id_id INT DEFAULT NULL, movie_id_id INT DEFAULT NULL, INDEX IDX_2968E103DC588714 (playlist_id_id), INDEX IDX_2968E10310684CB (movie_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reviews (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, movie_id_id INT NOT NULL, rating DOUBLE PRECISION DEFAULT NULL, review_text LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6970EB0F9D86650F (user_id_id), INDEX IDX_6970EB0F10684CB (movie_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_mood (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, mood_id_id INT DEFAULT NULL, INDEX IDX_79B8E23F9D86650F (user_id_id), INDEX IDX_79B8E23F76C5A04A (mood_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE movie_playlists ADD CONSTRAINT FK_CDD318699D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE playlist_movies ADD CONSTRAINT FK_2968E103DC588714 FOREIGN KEY (playlist_id_id) REFERENCES movie_playlists (id)');
        $this->addSql('ALTER TABLE playlist_movies ADD CONSTRAINT FK_2968E10310684CB FOREIGN KEY (movie_id_id) REFERENCES movies (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reviews ADD CONSTRAINT FK_6970EB0F10684CB FOREIGN KEY (movie_id_id) REFERENCES movies (id)');
        $this->addSql('ALTER TABLE user_mood ADD CONSTRAINT FK_79B8E23F9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_mood ADD CONSTRAINT FK_79B8E23F76C5A04A FOREIGN KEY (mood_id_id) REFERENCES moods (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie_playlists DROP FOREIGN KEY FK_CDD318699D86650F');
        $this->addSql('ALTER TABLE playlist_movies DROP FOREIGN KEY FK_2968E103DC588714');
        $this->addSql('ALTER TABLE playlist_movies DROP FOREIGN KEY FK_2968E10310684CB');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F9D86650F');
        $this->addSql('ALTER TABLE reviews DROP FOREIGN KEY FK_6970EB0F10684CB');
        $this->addSql('ALTER TABLE user_mood DROP FOREIGN KEY FK_79B8E23F9D86650F');
        $this->addSql('ALTER TABLE user_mood DROP FOREIGN KEY FK_79B8E23F76C5A04A');
        $this->addSql('DROP TABLE moods');
        $this->addSql('DROP TABLE movie_playlists');
        $this->addSql('DROP TABLE movies');
        $this->addSql('DROP TABLE playlist_movies');
        $this->addSql('DROP TABLE reviews');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_mood');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
