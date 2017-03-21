CREATE TABLE IF NOT EXISTS users (
  user_id int(11) AUTO_INCREMENT,
  name varchar(255) NOT NULL UNIQUE,
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
  CONSTRAINT post_author FOREIGN KEY (posted_by) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS tags (
  tag_id int(11) AUTO_INCREMENT,
  tag_name varchar(255) NOT NULL UNIQUE,
  PRIMARY KEY (tag_id)
);

CREATE TABLE IF NOT EXISTS posts_tags (
  id int(11) AUTO_INCREMENT,
  post_id int(11) NOT NULL,
  tag_id int(11) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT parent_post FOREIGN KEY (post_id) REFERENCES posts(post_id),	
  CONSTRAINT parent_tag FOREIGN KEY (tag_id) REFERENCES tags(tag_id),
  UNIQUE INDEX(post_id, tag_id)
);

INSERT INTO users (user_id, name, password, admin) VALUES (NULL, 'teddy', '57df73b3cca145ac3d34a8d4581522f7344e07e0ccf071b0727f24a3e9748e63', 1);
INSERT INTO posts (post_id, title, content, posted_by) VALUES (NULL, 'Home', '<p>Welcome to my blog!</p><p>This blog is powered by an in-house blog script written in PHP.</p>', 1);
INSERT INTO tags (tag_id, tag_name) VALUES (NULL, 'cute');
INSERT INTO posts_tags(id, post_id, tag_id) VALUES (NULL, 1, 1);