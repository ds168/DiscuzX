<?php
if(!defined('IN_ADMINCP')) exit('Access Denied');
$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_dsu_paulsign`;
CREATE TABLE IF NOT EXISTS `cdb_dsu_paulsign` (
  `uid` int(10) unsigned NOT NULL,
  `time` int(10) NOT NULL,
  `days` int(5) NOT NULL DEFAULT '0',
  `lasted` int(5) NOT NULL DEFAULT '0',
  `mdays` int(5) NOT NULL DEFAULT '0',
  `reward` int(12) NOT NULL DEFAULT '0',
  `lastreward` int(12) NOT NULL DEFAULT '0',
  `qdxq` varchar(5) NOT NULL,
  `todaysay` varchar(100) NOT NULL,
  PRIMARY KEY (`uid`),
  KEY `time` (`time`)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `cdb_dsu_paulsignset`;
CREATE TABLE IF NOT EXISTS `cdb_dsu_paulsignset` (
  `id` int(10) unsigned NOT NULL,
  `todayq` int(10) NOT NULL DEFAULT '0',
  `yesterdayq` int(10) NOT NULL DEFAULT '0',
  `highestq` int(10) NOT NULL DEFAULT '0',
  `qdtidnumber` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
INSERT INTO `cdb_dsu_paulsignset` (id, todayq, yesterdayq, highestq, qdtidnumber) VALUES ('1', '0', '0', '0', '0');
DROP TABLE IF EXISTS `cdb_dsu_paulsignemot`;
CREATE TABLE IF NOT EXISTS `cdb_dsu_paulsignemot` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `qdxq` varchar(5) NOT NULL,
  `count` int(6) NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
INSERT INTO `cdb_dsu_paulsignemot` (`id`, `displayorder`, `qdxq`, `name`) VALUES
(1, 1, 'kx', '$installlang[mb_qb1]'),
(2, 2, 'ng', '$installlang[mb_qb2]'),
(3, 3, 'ym', '$installlang[mb_qb3]'),
(4, 4, 'wl', '$installlang[mb_qb4]'),
(5, 5, 'nu', '$installlang[mb_qb5]'),
(6, 6, 'ch', '$installlang[mb_qb6]'),
(7, 7, 'fd', '$installlang[mb_qb7]'),
(8, 8, 'yl', '$installlang[mb_qb8]'),
(9, 9, 'shuai', '$installlang[mb_qb9]');
EOF;
runquery($sql);
$cacheechos = array();
$cacheechokeys = array();
$queryc = DB::query("SELECT * FROM ".DB::table('dsu_paulsignemot')." ORDER BY displayorder");
while($cacheecho = DB::fetch($queryc)) {
	$cacheechos[$cacheecho['qdxq']] = $cacheecho;
	$cacheechokeys[] = $cacheecho['qdxq'];

}
C::t('common_setting')->update('paulsign_emot', $cacheechos);
updatecache('setting');
$finish = TRUE;
?>