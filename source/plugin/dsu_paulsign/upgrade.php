<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(!$row = DB::fetch_first("SHOW COLUMNS FROM ".DB::table('dsu_paulsign')." LIKE 'lasted'")) {
	DB::query("ALTER TABLE ".DB::table('dsu_paulsign')." ADD lasted int(5) NOT NULL DEFAULT '0'");
}
$query3 = DB::query("SHOW TABLES LIKE '".DB::table('dsu_paulsignemot')."'");
if(DB::num_rows($query3) <= 0){
$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_dsu_paulsignemot`;
CREATE TABLE IF NOT EXISTS `cdb_dsu_paulsignemot` (
  `id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `displayorder` tinyint(3) NOT NULL DEFAULT '0',
  `qdxq` varchar(5) NOT NULL,
  `count` int(6) NOT NULL DEFAULT '0',
  `name` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
INSERT INTO `cdb_dsu_paulsignemot` (`id`, `displayorder`, `qdxq`, `count`, `name`) VALUES
(1, 1, 'kx', '0', '$installlang[mb_qb1]'),
(2, 2, 'ng', '0', '$installlang[mb_qb2]'),
(3, 3, 'ym', '0', '$installlang[mb_qb3]'),
(4, 4, 'wl', '0', '$installlang[mb_qb4]'),
(5, 5, 'nu', '0', '$installlang[mb_qb5]'),
(6, 6, 'ch', '0', '$installlang[mb_qb6]'),
(7, 7, 'fd', '0', '$installlang[mb_qb7]'),
(8, 8, 'yl', '0', '$installlang[mb_qb8]'),
(9, 9, 'shuai', '0', '$installlang[mb_qb9]');
EOF;
runquery($sql);
}
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