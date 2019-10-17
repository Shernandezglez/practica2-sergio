CREATE TABLE `datos` (
  `id` int(8) unsigned NOT NULL auto_increment,
  `nombre` varchar(70) default NULL,
  `direccion` varchar(120) default NULL,
  `fechaCreacion` timestamp NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;