CREATE TABLE `site_logins` (
	ID INT(11) NOT NULL AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL,
	hash VARCHAR(255) NOT NULL,
	PRIMARY KEY (ID)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `customer_details` (
	customer_id INT(11) NOT NULL AUTO_INCREMENT,
	email VARCHAR(255) NOT NULL,
	firstname VARCHAR(100) NOT NULL,
	lastname VARCHAR(100) NOT NULL,
	company VARCHAR(100) NOT NULL,
	address1 VARCHAR(255) NOT NULL,
	address2 VARCHAR(255) NOT NULL,
	town VARCHAR(65) NOT NULL,
	county VARCHAR(30) NOT NULL,
	postcode VARCHAR(9) NOT NULL,
	phone VARCHAR(15) NOT NULL,
	notes TEXT NOT NULL,
	PRIMARY KEY (customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `invoice_main` (
	invoice_id INT(11) NOT NULL AUTO_INCREMENT,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	discount DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
	order_total DECIMAL(10, 2) NOT NULL,
	proforma_id INT(11) NOT NULL,
	customer_id INT(11) NOT NULL,
	PRIMARY KEY (invoice_id),
	FOREIGN KEY (customer_id) REFERENCES `customer_details`(customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `invoice_lines` (
	line_id INT(11) NOT NULL AUTO_INCREMENT,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	line_price DECIMAL(10, 2) NOT NULL,
	invoice_id INT(11) NOT NULL,
	PRIMARY KEY (line_id),
	FOREIGN KEY (invoice_id) REFERENCES `invoice_main`(invoice_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `proforma_main` (
	proforma_id INT(11) NOT NULL AUTO_INCREMENT,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	discount DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
	order_total DECIMAL(10, 2) NOT NULL,
	invoiced TINYINT(1) NOT NULL DEFAULT 0,
	customer_id INT(11) NOT NULL,
	PRIMARY KEY (proforma_id),
	FOREIGN KEY (customer_id) REFERENCES `customer_details`(customer_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `proforma_lines` (
	line_id INT(11) NOT NULL AUTO_INCREMENT,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
	product_sku VARCHAR(20) NOT NULL,
	line_price DECIMAL(10, 2) NOT NULL,
	customer_id INT(11) NOT NULL,
	proforma_id INT(11) NOT NULL,
	PRIMARY KEY (line_id),
	FOREIGN KEY (proforma_id) REFERENCES `proforma_main`(proforma_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



/* Copy proforma lines to invoice */

INSERT INTO `invoice_main` (discount, order_total, customer_id)
SELECT discount, order_total, customer_id
FROM `proforma_main`
WHERE order_id= :order_id

UPDATE `proforma_main`
SET invoiced=1
WHERE order_id= :order_id
