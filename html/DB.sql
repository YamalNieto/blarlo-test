CREATE DATABASE store;

CREATE TABLE `store`.`categories` (
   `id` INT NOT NULL AUTO_INCREMENT ,
   `category` VARCHAR(20) NOT NULL ,
   PRIMARY KEY (`id`)
);

CREATE TABLE `store`.`products` (
    `id` INT NOT NULL AUTO_INCREMENT ,
    `category_id` INT NOT NULL ,
    `price` DECIMAL(10,2) NOT NULL ,
    `stock` INT NOT NULL,
    `last_purchase_date` TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`category_id`) REFERENCES categories(id)
);

CREATE TABLE `store`.`locale` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `iso` VARCHAR(3) NOT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `store`.`productLocale` (
    `product_id` INT NOT NULL,
    `locale_id` INT NOT NULL,
    `name` TEXT,
    `description` TEXT,
    PRIMARY KEY (`product_id`, `locale_id`),
    CONSTRAINT FK_locale FOREIGN KEY (`locale_id`) REFERENCES locale(id),
    CONSTRAINT FK_product FOREIGN KEY (`product_id`) REFERENCES products(id)
);

INSERT INTO `store`.`locale` (id, iso)
VALUES
(1, 'esp'),
(2, 'eng'),
(3, 'fra');