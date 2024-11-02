-- PostgreSQL SQL Dump
-- Database: ecommerce

-- Procedures
CREATE OR REPLACE FUNCTION fetch_client(nom VARCHAR, prenom VARCHAR, tel INT, login_email VARCHAR, login_password VARCHAR)
RETURNS INT AS $$
DECLARE
    message INT;
BEGIN
    IF NOT EXISTS (SELECT 1 FROM client WHERE login_email = login_email AND login_password = login_password) THEN
        message := 1;
    ELSE
        message := 0;
    END IF;
    RETURN message;
END; $$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION inserttocart(id_client INT, id_product INT, quantity INT, total INT)
RETURNS VOID AS $$
BEGIN
    INSERT INTO cart (id_client, id_product, quantity, total, date)
    VALUES (id_client, id_product, quantity, total, CURRENT_TIMESTAMP);
END; $$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION inserttocommandelist(id_client INT, id_product INT, quantity INT, total INT)
RETURNS VOID AS $$
BEGIN
    INSERT INTO commandelist (id_client, id_product, quantity, total, date)
    VALUES (id_client, id_product, quantity, total, CURRENT_TIMESTAMP);
END; $$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insrt_client(nom VARCHAR, prenom VARCHAR, tel INT, login_emailc VARCHAR, login_password VARCHAR)
RETURNS INT AS $$
DECLARE
    message INT;
BEGIN
    IF NOT EXISTS (SELECT 1 FROM client WHERE login_email = login_emailc) THEN
        INSERT INTO client (nom, prenom, tel, login_email, login_password)
        VALUES (nom, prenom, tel, login_emailc, login_password);
        message := 1;
    ELSE
        message := 0;
    END IF;
    RETURN message;
END; $$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insrt_login(emailc VARCHAR, passwordc VARCHAR, typec VARCHAR)
RETURNS INT AS $$
DECLARE
    message INT;
BEGIN
    IF NOT EXISTS (SELECT 1 FROM login WHERE email = emailc) THEN
        INSERT INTO login (email, password, user_type)
        VALUES (emailc, passwordc, typec);
        message := 1;
    ELSE
        message := 0;
    END IF;
    RETURN message;
END; $$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION insrt_product(nom VARCHAR, prix INT, discount INT, category VARCHAR, dateCreation TIMESTAMP, quantity INT, image_url VARCHAR)
RETURNS VOID AS $$
BEGIN
    INSERT INTO produit (nom, prix, discount, category, dateCreation, quantity, image_url) 
    VALUES (nom, prix, discount, category, dateCreation, quantity, image_url);
END; $$ LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION test_login(emailc VARCHAR, passwordc VARCHAR)
RETURNS INT AS $$
DECLARE
    message INT;
BEGIN
    IF NOT EXISTS (SELECT 1 FROM login WHERE email = emailc AND password = passwordc) THEN
        message := 0;
    ELSE
        message := 1;
    END IF;
    RETURN message;
END; $$ LANGUAGE plpgsql;

-- --------------------------------------------------------

-- Table structure for table admin
DROP TABLE IF EXISTS admin;
CREATE TABLE IF NOT EXISTS admin (
  id SERIAL PRIMARY KEY,
  nom VARCHAR(60) NOT NULL,
  prenom VARCHAR(60) NOT NULL,
  tel INT NOT NULL,
  login_email VARCHAR(60) UNIQUE,
  login_password VARCHAR(60) UNIQUE
);

-- Dumping data for table admin
INSERT INTO admin (id, nom, prenom, tel, login_email, login_password) VALUES
(1, 'iliass', 'wakkar', 674007987, 'iliass.wakkar@um5r.ac.ma', 'iliass2001');

-- --------------------------------------------------------

-- Table structure for table cart
DROP TABLE IF EXISTS cart;
CREATE TABLE IF NOT EXISTS cart (
  id SERIAL PRIMARY KEY,
  id_client INT NOT NULL,
  id_product INT NOT NULL,
  quantity INT NOT NULL,
  total INT NOT NULL,
  date TIMESTAMP NOT NULL,
  UNIQUE (id_client, id_product, quantity, date)
);

-- Dumping data for table cart
INSERT INTO cart (id, id_client, id_product, quantity, total, date) VALUES
(31, 6, 2, 3, 120060, '2024-10-01 14:08:42'),
(32, 6, 15, 3, 150, '2024-10-29 23:47:27');

-- --------------------------------------------------------

-- Table structure for table category
DROP TABLE IF EXISTS category;
CREATE TABLE IF NOT EXISTS category (
  id SERIAL PRIMARY KEY,
  nom VARCHAR(100) NOT NULL UNIQUE,
  description VARCHAR(200)
);

-- Dumping data for table category
INSERT INTO category (id, nom, description) VALUES
(1, 'Books', 'Literature and Fiction'),
(2, 'electronics', 'ssssssss');

-- --------------------------------------------------------

-- Table structure for table client
DROP TABLE IF EXISTS client;
CREATE TABLE IF NOT EXISTS client (
  id SERIAL PRIMARY KEY,
  nom VARCHAR(60) NOT NULL,
  prenom VARCHAR(60) NOT NULL,
  tel INT NOT NULL,
  login_email VARCHAR(60) UNIQUE,
  login_password VARCHAR(60) UNIQUE
);

-- Dumping data for table client
INSERT INTO client (id, nom, prenom, tel, login_email, login_password) VALUES
(2, 'Iliass2', 'Wakkar', 2147483647, 'iliasswakkar2@gmail.com', '0000'),
(3, 'Iliass', 'Wakkar', 655240541, 'iliasswakkar22@gmail.com', '1111'),
(6, 'wakkar', 'iliass', 674007987, 'email@gmail.com', 'atelier');

-- --------------------------------------------------------

-- Table structure for table commandelist
DROP TABLE IF EXISTS commandelist;
CREATE TABLE IF NOT EXISTS commandelist (
  id SERIAL PRIMARY KEY,
  id_client INT NOT NULL,
  id_product INT NOT NULL,
  quantity INT NOT NULL,
  total INT NOT NULL,
  date TIMESTAMP NOT NULL
);

-- Dumping data for table commandelist
INSERT INTO commandelist (id, id_client, id_product, quantity, total, date) VALUES
(2, 2, 1, 5, 20000, '2024-05-02 16:31:30'),
(3, 2, 1, 3, 12000, '2024-05-02 22:00:41'),
(4, 3, 2, 5, 40000, '2024-05-02 15:44:05'),
(11, 2, 4, 4, 180000, '2024-05-16 00:45:33'),
(15, 2, 9, 3, 600, '2024-05-16 10:00:32'),
(17, 2, 14, 3, 1050, '2024-05-16 10:00:47'),
(18, 2, 4, 3, 135000, '2024-05-16 10:00:47'),
(20, 2, 9, 2, 400, '2024-05-16 10:09:33'),
(22, 2, 9, 3, 600, '2024-05-16 10:09:43'),
(23, 2, 9, 2, 400, '2024-05-16 10:09:43'),
(24, 2, 4, 2, 90000, '2024-05-16 10:09:43');

-- --------------------------------------------------------

-- Table structure for table login
DROP TABLE IF EXISTS login;
CREATE TABLE IF NOT EXISTS login (
  email VARCHAR(80) PRIMARY KEY,
  password VARCHAR(50) NOT NULL,
  user_type VARCHAR(10) CHECK (user_type IN ('Admin','Client'))
);

-- Dumping data for table login
INSERT INTO login (email, password, user_type) VALUES
('email@gmail.com', 'atelier', 'Client'),
('iliass.wakkar@um5r.ac.ma', 'iliass2001', 'Admin'),
('iliasswakkar2@gmail.com', '0000', 'Client'),
('iliasswakkar22@gmail.com', '1111', 'Client'),
('iliasswakkar29@gmail.com', '5555', 'Client');

-- --------------------------------------------------------

-- Table structure for table produit
DROP TABLE IF EXISTS produit;
CREATE TABLE IF NOT EXISTS produit (
  id SERIAL PRIMARY KEY,
  nom VARCHAR(255) NOT NULL,
  prix INT NOT NULL,
  discount INT,
  category VARCHAR(120),
  dateCreation TIMESTAMP,
  quantity INT,
  image_url VARCHAR(120)
);
