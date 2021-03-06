CREATE TABLE articles (id INT AUTO_INCREMENT, title VARCHAR(180) NOT NULL, text TEXT NOT NULL, category_id INT NOT NULL, published_at DATETIME NOT NULL, read_count INT NOT NULL, user_id INT NOT NULL, published TINYINT NOT NULL, photo VARCHAR(255) NOT NULL, INDEX category_id_idx (category_id), INDEX user_id_idx (user_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE articles_tags (articles_id INT, tags_id INT, PRIMARY KEY(articles_id, tags_id)) ENGINE = INNODB;
CREATE TABLE categories (id INT AUTO_INCREMENT, name VARCHAR(30) NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE comments (id INT AUTO_INCREMENT, user_id INT NOT NULL, text TEXT NOT NULL, article_id INT NOT NULL, published_at DATETIME NOT NULL, published TINYINT NOT NULL, INDEX user_id_idx (user_id), INDEX article_id_idx (article_id), PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE roles (id INT AUTO_INCREMENT, name VARCHAR(9) NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE tags (id INT AUTO_INCREMENT, text VARCHAR(255) NOT NULL, PRIMARY KEY(id)) ENGINE = INNODB;
CREATE TABLE users (id INT AUTO_INCREMENT, role_id INT NOT NULL, username VARCHAR(60) NOT NULL, password VARCHAR(90) NOT NULL, active TINYINT NOT NULL, name VARCHAR(50) NOT NULL, surname VARCHAR(80) NOT NULL, email VARCHAR(60) NOT NULL, nickname VARCHAR(60) NOT NULL, INDEX role_id_idx (role_id), PRIMARY KEY(id)) ENGINE = INNODB;
ALTER TABLE articles ADD CONSTRAINT articles_user_id_users_id FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE articles ADD CONSTRAINT articles_category_id_categories_id FOREIGN KEY (category_id) REFERENCES categories(id);
ALTER TABLE articles_tags ADD CONSTRAINT articles_tags_tags_id_tags_id FOREIGN KEY (tags_id) REFERENCES tags(id);
ALTER TABLE articles_tags ADD CONSTRAINT articles_tags_articles_id_articles_id FOREIGN KEY (articles_id) REFERENCES articles(id);
ALTER TABLE comments ADD CONSTRAINT comments_user_id_users_id FOREIGN KEY (user_id) REFERENCES users(id);
ALTER TABLE comments ADD CONSTRAINT comments_article_id_articles_id FOREIGN KEY (article_id) REFERENCES articles(id);
ALTER TABLE users ADD CONSTRAINT users_role_id_roles_id FOREIGN KEY (role_id) REFERENCES roles(id);
