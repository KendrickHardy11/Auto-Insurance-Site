CREATE DATABASE 466_quote;

USE 466_quote;

CREATE TABLE sales_associates (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(50) NOT NULL,
  commission DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  address VARCHAR(50) NOT NULL
);

CREATE TABLE customers (
  id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(50),
  city VARCHAR(50),
  street VARCHAR(50),
  contact VARCHAR(50)
);

CREATE TABLE quotes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  customer_id INT NOT NULL,
  sales_associate_id INT NOT NULL,
  email VARCHAR(50) NOT NULL,
  status ENUM('draft', 'finalized', 'sanctioned', 'ordered') NOT NULL DEFAULT 'draft',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (customer_id) REFERENCES customers(id),
  FOREIGN KEY (sales_associate_id) REFERENCES sales_associates(id)
);

CREATE TABLE notes (
  id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
  quote_id INT(11) NOT NULL,
  note TEXT NOT NULL,
  FOREIGN KEY (quote_id) REFERENCES quotes(id)
);

CREATE TABLE quote_line_items (
  id INT PRIMARY KEY AUTO_INCREMENT,
  quote_id INT NOT NULL,
  description TEXT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (quote_id) REFERENCES quotes(id)
);

CREATE TABLE discounts (
  id INT PRIMARY KEY AUTO_INCREMENT,
  quote_id INT NOT NULL,
  type ENUM('percentage', 'amount') NOT NULL,
  value DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (quote_id) REFERENCES quotes(id)
);

CREATE TABLE purchase_orders (
  id INT PRIMARY KEY AUTO_INCREMENT,
  quote_id INT NOT NULL,
  final_discount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  processing_date TIMESTAMP NOT NULL,
  FOREIGN KEY (quote_id) REFERENCES quotes(id)
);

CREATE TABLE commissions (
  id INT PRIMARY KEY AUTO_INCREMENT,
  sales_associate_id INT NOT NULL,
  quote_id INT NOT NULL,
  commission_rate DECIMAL(10,2) NOT NULL,
  amount DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (sales_associate_id) REFERENCES sales_associates(id),
  FOREIGN KEY (quote_id) REFERENCES quotes(id)
);
