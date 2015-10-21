

CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    nome varchar(30)) ENGINE=INNODB;

CREATE TABLE telefone (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    numero varchar(30),
    clientes_id INT,
    FOREIGN KEY(clientes_id) REFERENCES clientes(id)) ;

CREATE TABLE email (
    id INT AUTO_INCREMENT PRIMARY KEY NOT NULL,
    email varchar(30),
    clientes_id INT,
    FOREIGN KEY(clientes_id) REFERENCES clientes(id));

