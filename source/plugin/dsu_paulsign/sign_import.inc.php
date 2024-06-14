<?php
/*
	dsu_paulsign Import By shy9000[DSU Team] 2011-06-19
*/
!defined('IN_DISCUZ') && exit('Access Denied');
!defined('IN_ADMINCP') && exit('Access Denied');
loadcache('pluginlanguage_script');
$lang = $_G['cache']['pluginlanguage_script']['dsu_paulsign'];
if(is_file(DISCUZ_ROOT.'./data/dsu_paulsign_import.lock'))cpmsg("{$lang[import_16]}", '');
if(!$_GET['submit']) {
	showtableheader($lang['import_07'].' 20110619 By [DSU]Shy9000');
	showformheader("plugins&operation=config&identifier=dsu_paulsign&pmod=sign_import&submit=1", "");
	echo '<tr><td colspan="2" class="td27" s="1">'.$lang['import_08'].':</td></tr>
	<tr class="noborder""><td class="vtop rowform">
	<ul class="nofloat" onmouseover="altStyle(this);"><li><input class="radio" type="radio" name="imchoice" value="1"  onclick="if(checked){document.getElementById(\'s1\').style.display=\'none\';document.getElementById(\'s2\').style.display=\'none\';document.getElementById(\'y1\').style.display=\'none\';document.getElementById(\'y2\').style.display=\'none\';}">&nbsp;[DSU]'.$lang['import_09'].' For X2.0</li><li class="checked"><input class="radio" type="radio" name="imchoice" value="2" onclick="if(checked){document.getElementById(\'s1\').style.display=\'\';document.getElementById(\'s2\').style.display=\'\';document.getElementById(\'y1\').style.display=\'\';document.getElementById(\'y2\').style.display=\'\';}" checked>&nbsp;[DPS]'.$lang['import_10'].' For 7.2</li><li><input class="radio" type="radio" name="imchoice" value="3" onclick="if(checked){document.getElementById(\'s1\').style.display=\'none\';document.getElementById(\'s2\').style.display=\'none\';document.getElementById(\'y1\').style.display=\'none\';document.getElementById(\'y2\').style.display=\'none\';}">&nbsp;'.$lang['import_11'].' 1.5 For X1.0</li></ul></td><td class="vtop tips2" s="1"></td></tr>
	<tr id="s1"><td colspan="2" class="td27" s="1">'.$lang['import_02'].':</td></tr>
	<tr id="s2" class="noborder"><td class="vtop rowform">
	<input name="signt" value="cdb_dps_sign" type="text" class="txt"/></td><td class="vtop tips2" s="1"></td></tr>
	<tr id="y1"><td colspan="2" class="td27" s="1">'.$lang['import_03'].':</td></tr>
	<tr id="y2" class="noborder"><td class="vtop rowform">
	<input name="signsett" value="cdb_dps_signset" type="text" class="txt"/></td><td class="vtop tips2" s="1"></td></tr>';
	echo '<input type="hidden" name="formhash" value="'.FORMHASH.'">';
	showsubmit('submit', $lang['import_12']);
	showformfooter();
	showtablefooter();
} elseif($_GET['imchoice'] && $_GET['submit'] && $_G['adminid']=='1' && $_GET['formhash']==FORMHASH) {
	if($_GET['imchoice'] == '3'){
		$query1 = DB::query("SHOW TABLES LIKE '".DB::table('rs_sign')."'");
		$query2 = DB::query("SHOW TABLES LIKE '".DB::table('rs_signset')."'");
		if(DB::num_rows($query1) <= 0 || DB::num_rows($query2) <= 0)cpmsg("{$lang[import_13]}", '');
		DB::query("DROP TABLE IF EXISTS ".DB::table('dsu_paulsign')."");
		DB::query("DROP TABLE IF EXISTS ".DB::table('dsu_paulsignset')."");
		DB::query("RENAME TABLE ".DB::table('rs_sign')." TO ".DB::table('dsu_paulsign')."");
		DB::query("RENAME TABLE ".DB::table('rs_signset')." TO ".DB::table('dsu_paulsignset')."");
	}elseif($_GET['imchoice'] == '1'){
			$query1 = DB::query("SHOW TABLES LIKE '".DB::table('plugin_dsuampper')."'");
			if(DB::num_rows($query1) <= 0)cpmsg("{$lang[import_13]}", '');
			$query = DB::query("SELECT * FROM ".DB::table('plugin_dsuampper')."");
			$mrcs = array();
			while($mrc = DB::fetch($query)) {
				$mrc['ifcz'] = DB::fetch_first("SELECT * FROM ".DB::table('dsu_paulsign')." WHERE uid='$mrc[uid]'");
				if(!$mrc['ifcz']['uid']) {
					DB::query("INSERT INTO ".DB::table('dsu_paulsign')." (uid,time,days,mdays,reward,lastreward,qdxq,todaysay) VALUES ('$mrc[uid]','$mrc[lasttime]','$mrc[addup]','$mrc[continuous]','0','0','kx','')");
				}else{
					$mrc['im_days']= $mrc['ifcz']['days'] + $mrc['addup'];
					$mrc['im_mdays']= $mrc['ifcz']['mdays'] + $mrc['continuous'];
					$mrc['im_reward']= $mrc['ifcz']['reward'];
					DB::query("UPDATE ".DB::table('dsu_paulsign')." SET days='$mrc[im_days]',mdays='$mrc[im_mdays]',reward='$mrc[im_reward]' WHERE uid='$mrc[uid]'");
				}
				$mrcs[] = $mrc;
			}
	}elseif($_GET['imchoice'] == '2'){
			if(!$_GET['signsett'] || !$_GET['signt'])cpmsg("{$lang[import_14]}", '');
			$query1 = DB::query("SHOW TABLES LIKE '{$_GET[signsett]}'");
			$query2 = DB::query("SHOW TABLES LIKE '{$_GET[signt]}'");
			if(DB::num_rows($query1) <= 0 || DB::num_rows($query2) <= 0)cpmsg("{$lang[import_13]}", '');
			$tj = DB::fetch_first("SELECT * FROM {$_GET[signsett]} where id='1'");
			if($tj){
				DB::query("UPDATE ".DB::table('dsu_paulsignset')." SET todayq='$tj[todayq]',yesterdayq='$tj[yesterdayq]',highestq='$tj[highestq]',qdtidnumber='$tj[qdtidnumber]' WHERE id='1'");
			}else{
				cpmsg("{$lang[import_04]}", '');
			}
			$query = DB::query("SELECT * FROM {$_GET[signt]}");
			if(!$query){
				cpmsg("{$lang[import_05]}", '');
			}
			$mrcs = array();
			while($mrc = DB::fetch($query)) {
				$mrc['ifcz'] = DB::fetch_first("SELECT * FROM ".DB::table('dsu_paulsign')." WHERE uid='$mrc[uid]'");
				if(!$mrc['ifcz']['uid']) {
					$mrc['todaysay'] = dhtmlspecialchars($mrc['todaysay']);
					$mrc['todaysay'] = daddslashes($mrc['todaysay']);
					DB::query("INSERT INTO ".DB::table('dsu_paulsign')." (uid,time,days,mdays,reward,lastreward,qdxq,todaysay) VALUES ('$mrc[uid]','$mrc[time]','$mrc[days]','$mrc[mdays]','$mrc[reward]','$mrc[lastreward]','$mrc[qdxq]','$mrc[todaysay]')");
				}else{
					$mrc['im_days']= $mrc['ifcz']['days'] + $mrc['days'];
					$mrc['im_mdays']= $mrc['ifcz']['mdays'] + $mrc['mdays'];
					$mrc['im_reward']= $mrc['reward'] + $mrc['ifcz']['reward'];
					DB::query("UPDATE ".DB::table('dsu_paulsign')." SET days='$mrc[im_days]',mdays='$mrc[im_mdays]',reward='$mrc[im_reward]' WHERE uid='$mrc[uid]'");
				}
				$mrcs[] = $mrc;
			}
	}
	file_put_contents(DISCUZ_ROOT.'./data/dsu_paulsign_import.lock', '1');
	cpmsg("{$lang[import_06]}", '', 'succeed');
}else{
	cpmsg("{$lang[import_15]}", '');
}
?>