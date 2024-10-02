use bookshop;
create database bookshop;

CREATE TABLE Products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,  -- Item name (e.g., pencil, exercise book)
    information VARCHAR(100),  -- Optional, to categorize (e.g., writing, notebooks)
    price DECIMAL(10, 2),  -- Price per unit
    stock INT DEFAULT 0  -- Number of items left in stock
);

CREATE TABLE Sales (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,  -- Reference to the Products table
    sale_date DATE,  -- Date of the sale
    quantity INT,  -- Quantity of the item sold
    total DECIMAL(10, 2),  -- Total amount for the sale (price * quantity)
    FOREIGN KEY (product_id) REFERENCES Products(id)
);

CREATE VIEW DailySales AS
SELECT
    sale_date,
    SUM(quantity) AS total_items_sold,
    SUM(total) AS total_sales
FROM Sales
GROUP BY sale_date;


CREATE VIEW WeeklySales AS
SELECT
    CONCAT(YEAR(sale_date), ' - Week ', WEEK(sale_date, 1)) AS week_label,
    MIN(sale_date) AS start_date,
    MAX(sale_date) AS end_date,
    SUM(quantity) AS total_items_sold,
    SUM(total) AS total_sales
FROM Sales
GROUP BY YEARWEEK(sale_date);

SET FOREIGN_KEY_CHECKS = 1;
TRUNCATE TABLE sales

