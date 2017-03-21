CREATE DATABASE IF NOT EXISTS db;

USE db;

CREATE TABLE IF NOT EXISTS users (
  user_id int(11) AUTO_INCREMENT,
  name varchar(255) NOT NULL DEFAULT '',
  password varchar(255) NOT NULL DEFAULT '',
  admin int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS posts (
  post_id int(11) AUTO_INCREMENT,
  title varchar(255) NOT NULL DEFAULT '',
  content text NOT NULL DEFAULT '',
  date datetime NOT NULL DEFAULT NOW(),
  posted_by int(11) NOT NULL,
  PRIMARY KEY (post_id),
  FOREIGN KEY (posted_by) REFERENCES users(user_id)
);

ALTER TABLE users ADD UNIQUE (name);

INSERT INTO users (user_id, name, password, admin) VALUES (NULL, 'teddy', '57df73b3cca145ac3d34a8d4581522f7344e07e0ccf071b0727f24a3e9748e63', 1);
INSERT INTO posts (post_id, title, content, posted_by) VALUES (NULL, 'Home', '<p>Welcome to my blog!</p><p>This blog is powered by an in-house blog script written in PHP.</p>', 1);