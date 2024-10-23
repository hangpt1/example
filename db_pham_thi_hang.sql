create database db_pham_thi_hang;

use db_pham_thi_hang;

CREATE TABLE `Course` (
  `id` int(10) NOT NULL auto_increment,
  `Title` varchar(255) NOT NULL,
  `Description` text NOT NULL,
  `ImageUrl` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
);

INSERT INTO `Course` (`Id`, `Title`, `Description`, `ImageUrl`) VALUES
(1, 'Laravel Programming', 'This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.', 'angular.png');
