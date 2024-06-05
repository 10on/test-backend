USE my_database;

CREATE TABLE users
(
    id INT AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    email VARCHAR(256) NOT NULL,
    created DATETIME NOT NULL,
    deleted DATETIME NULL,
    notes TEXT NULL,
    CONSTRAINT users_pk PRIMARY KEY (id)
);

CREATE UNIQUE INDEX users_email_uindex
    ON users (email);

CREATE UNIQUE INDEX users_name_uindex
    ON users (name);