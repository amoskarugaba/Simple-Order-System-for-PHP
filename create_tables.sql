/* Customer table with customer id (as PK)
 * Orders table with all orders (order id as PK) and customer id (as FK)
 * Individual order lines with orderid as FK
*/

CREATE TABLE `orders_main` ( order_id INT(11) NOT NULL AUTO_INCREMENT, date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, discount DECIMAL(5, 2) NOT NULL DEFAULT 0.00, order_total DECIMAL(10, 2) NOT NULL, customer_id INT(11) NOT NULL, PRIMARY KEY (email), FOREIGN KEY (customer_id) REFERENCES `customer_details`(customer_id) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `order_lines` ( line_id INT(11) NOT NULL AUTO_INCREMENT, date TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, line_price DECIMAL(10, 2) NOT NULL, order_id INT(11) NOT NULL, PRIMARY KEY (order_lines), FOREIGN KEY (order_id) REFERENCES `orders_main`(order_id) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;

