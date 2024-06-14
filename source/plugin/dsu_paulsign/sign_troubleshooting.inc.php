<?php
/*
	dsu_paulsign Helper By shy9000[DSU Team] 2011-06-19
*/
!defined('IN_DISCUZ') && exit('Access Denied');
!defined('IN_ADMINCP') && exit('Access Denied');
if($_G['adminid']!=='1') exit('Access Denied');
$lang = $_G['cache']['pluginlanguage_script']['dsu_paulsign'];
$query1 = DB::query("SHOW TABLES LIKE '".DB::table('dsu_paulsign')."'");
$query2 = DB::query("SHOW TABLES LIKE '".DB::table('dsu_paulsignset')."'");
$query3 = DB::query("SHOW TABLES LIKE '".DB::table('dsu_paulsignemot')."'");
if(!$row = DB::fetch_first("SHOW COLUMNS FROM ".DB::table('dsu_paulsign')." LIKE 'lasted'")) {
	DB::query("ALTER TABLE ".DB::table('dsu_paulsign')." ADD lasted int(5) NOT NULL DEFAULT '0'");
}
if(DB::num_rows($query1) > 0 && DB::num_rows($query2) > 0)cpmsg("Tables are Normal!", '', 'succeed');
if(DB::num_rows($query1) <= 0){
	$sql = <<<EOF
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
EOF;
	runquery($sql);
}
if(DB::num_rows($query2) <= 0){
	$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `cdb_dsu_paulsignset` (
  `id` int(10) unsigned NOT NULL,
  `todayq` int(10) NOT NULL DEFAULT '0',
  `yesterdayq` int(10) NOT NULL DEFAULT '0',
  `highestq` int(10) NOT NULL DEFAULT '0',
  `qdtidnumber` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
INSERT INTO `cdb_dsu_paulsignset` (id, todayq, yesterdayq, highestq, qdtidnumber) VALUES ('1', '0', '0', '0', '0');
EOF;
	runquery($sql);
}
if(DB::num_rows($query3) <= 0){
	$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `cdb_dsu_paulsignemot` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `qdxq` varchar(5) NOT NULL,
  `count` int(6) NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
INSERT INTO `cdb_dsu_paulsignemot` (`id`, `displayorder`, `qdxq`, `count`, `name`) VALUES
(1, 1, 'kx', '0', '$lang[mb_qb1]'),
(2, 2, 'ng', '0', '$lang[mb_qb2]'),
(3, 3, 'ym', '0', '$lang[mb_qb3]'),
(4, 4, 'wl', '0', '$lang[mb_qb4]'),
(5, 5, 'nu', '0', '$lang[mb_qb5]'),
(6, 6, 'ch', '0', '$lang[mb_qb6]'),
(7, 7, 'fd', '0', '$lang[mb_qb7]'),
(8, 8, 'yl', '0', '$lang[mb_qb8]'),
(9, 9, 'shuai', '0', '$lang[mb_qb9]');
EOF;
	runquery($sql);
}
cpmsg("Tables Fix Successfully!", '', 'succeed');
?>