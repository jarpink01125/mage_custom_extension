<?php

$installer = $this;

$installer->startSetup();
try {
    $installer->run("

CREATE TABLE IF NOT EXISTS {$this->getTable('reviews/reviews')} (
  `review_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `nickname` varchar(255) NOT NULL DEFAULT '',
  `ratings` tinyint(11) NOT NULL,
  `review_content` text NOT NULL,
  `status` smallint(6) NOT NULL DEFAULT '0',
  `created_time` datetime DEFAULT NULL,
  `update_time` datetime DEFAULT NULL,
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
");
} catch (Exception $e) {
    
}

$installer->endSetup();