<?php

$installer = $this;

$installer->startSetup();

$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('video')};
CREATE TABLE {$this->getTable('video')} (
  `video_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `shortdescription` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `small_image` varchar(255) NOT NULL default '',
  `full_image1` varchar(255) NOT NULL default '',
  `full_image2` varchar(255) NOT NULL default '',
  `full_image3` varchar(255) NOT NULL default '',
  `full_image4` varchar(255) NOT NULL default '',
  `full_image5` varchar(255) NOT NULL default '',
  `full_image6` varchar(255) NOT NULL default '',
  `full_image7` varchar(255) NOT NULL default '',
  `full_image8` varchar(255) NOT NULL default '',
  `full_image9` varchar(255) NOT NULL default '',
  `full_image10` varchar(255) NOT NULL default '',
  `url` varchar(255) NOT NULL default '',
  `position` varchar(255) NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  `store_view` int(11) NOT NULL,
  `year` int(11) DEFAULT NULL,
   PRIMARY KEY (`video_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");

$installer->endSetup(); 
