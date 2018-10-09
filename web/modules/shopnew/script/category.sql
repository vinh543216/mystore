/*DROP TABLE IF EXISTS `category`;
CREATE TABLE `category`(

 )*/
CREATE TABLE IF NOT EXISTS `shopnew_category`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar (500) NOT NULL ,
  `slug` text,
  `description` varchar (500) DEFAULT NULL ,
  `parent_id` int (11) DEFAULT 0,
  `image` TEXT DEFAULT NULL ,
  `created_at` int unsigned NULL COMMENT 'ngay tao',
  `updated_at` int unsigned NULL COMMENT 'ngay cap nhat',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- ALTER TABLE shopnew_product
-- ALTER COLUMN images  TYPE text;
-- ALTER COLUMN price TYPE text;

CREATE TABLE IF NOT EXISTS `shopnew_product`(
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar (500) NOT NULL ,
  `slug` text,
  `description` varchar (500) DEFAULT NULL ,
  `category_id` int,
  `content` text,
  `image` int(11) DEFAULT NULL ,
  `images` text,
  `price` text,
  `created_at` int NOT NULL ,
  `updated_at` int  DEFAULT NULL,
  PRIMARY KEY(`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
