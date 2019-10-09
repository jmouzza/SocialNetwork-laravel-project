CREATE DATABASE IF NOT EXISTS laravel_master CHARACTER SET utf8 COLLATE utf8_unicode_ci;
use laravel_master;

CREATE TABLE IF NOT EXISTS users(
id                  int(255) auto_increment not null,
role                varchar(20),
name                varchar(100),
surname             varchar(200),
nick                varchar(100),
email               varchar(255),
password            varchar(255),
image               varchar(255),
created_at          datetime,
updated_at          datetime,
remember_token      varchar(255),
CONSTRAINT pk_users PRIMARY KEY(id),
CONSTRAINT uq_email UNIQUE (email)
)ENGINE=InnoDb;

INSERT INTO users VALUES(null, 'user', 'Jesús', 'Mouzza', 'Pichu', 'jmouzza@gmail.com', '123456', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, 'user', 'Joaquín', 'Mouzza', 'Joaco', 'joaquin2019@gmail.com', '123456', null, CURTIME(), CURTIME(), null);
INSERT INTO users VALUES(null, 'user', 'Johani', 'Morin', 'Joha', 'johani@gmail.com', '123456', null, CURTIME(), CURTIME(), null);

CREATE TABLE IF NOT EXISTS images(
id                  int(255) auto_increment not null,
user_id             int(255),
image_path          varchar(255),
description         text,
created_at          datetime,
updated_at          datetime,
CONSTRAINT pk_images PRIMARY KEY(id),
CONSTRAINT fk_images_users FOREIGN KEY(user_id) REFERENCES users(id)
)ENGINE=InnoDb;

INSERT INTO images VALUES(null, 1, 'primera.jpg', 'Descripción de prueba 1era foto', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, 'segunda.jpg', 'Descripción de prueba 2da foto', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 1, 'tercera.jpg', 'Descripción de prueba 3era foto', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 3, 'cuarta.jpg', 'Descripción de prueba 4ta foto', CURTIME(), CURTIME());
INSERT INTO images VALUES(null, 2, 'quinta.jpg', 'Descripción de prueba 5ta foto', CURTIME(), CURTIME());

CREATE TABLE IF NOT EXISTS likes(
id                  int(255) auto_increment not null,
user_id             int(255),
image_id            int(255),
created_at          datetime,
updated_at          datetime,
CONSTRAINT pk_likes PRIMARY KEY(id),
CONSTRAINT fk_likes_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT fk_likes_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO likes VALUES(null,2,1,CURTIME(),CURTIME());
INSERT INTO likes VALUES(null,2,2,CURTIME(),CURTIME());
INSERT INTO likes VALUES(null,3,3,CURTIME(),CURTIME());
INSERT INTO likes VALUES(null,1,5,CURTIME(),CURTIME());
INSERT INTO likes VALUES(null,1,4,CURTIME(),CURTIME());
INSERT INTO likes VALUES(null,2,4,CURTIME(),CURTIME());
INSERT INTO likes VALUES(null,3,4,CURTIME(),CURTIME());
INSERT INTO likes VALUES(null,3,1,CURTIME(),CURTIME());
INSERT INTO likes VALUES(null,1,1,CURTIME(),CURTIME());

CREATE TABLE IF NOT EXISTS comments(
id                  int(255) auto_increment not null,      
user_id             int(255),
image_id            int(255),
content             text,
created_at          datetime,
updated_at          datetime,
CONSTRAINT  pk_comments PRIMARY KEY(id),
CONSTRAINT  fk_comments_users FOREIGN KEY(user_id) REFERENCES users(id),
CONSTRAINT  fk_comments_images FOREIGN KEY(image_id) REFERENCES images(id)
)ENGINE=InnoDb;

INSERT INTO comments VALUES(null,1,4,'Usuario 1 Comentario a 4ta imagen', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null,2,1,'Usuario 2 Comentario a 1era imagen', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null,2,3,'Usuario 2 Comentario a 3era imagen', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null,2,4,'Usuario 2 Comentario a 4ta imagen', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null,3,1,'Usuario 3 Comentario a 1era imagen', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null,3,5,'Usuario 1 Comentario a quinta imagen', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null,1,5,'Usuario 1 Comentario a 5ta imagen', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null,2,2,'Usuario 2 Comentario a 2da imagen', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null,3,4,'Usuario 3 Comentario a 4ta imagen', CURTIME(), CURTIME());
INSERT INTO comments VALUES(null,3,2,'Usuario 3 Comentario a 2da imagen', CURTIME(), CURTIME());

