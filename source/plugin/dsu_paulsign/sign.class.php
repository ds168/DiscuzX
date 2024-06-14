<?php
/*
	dsu_paulsign Echo By shy9000[DSU.CC] 2011-07-15
*/
!defined('IN_DISCUZ') && exit('Access Denied');
class plugin_dsu_paulsign{
	function global_usernav_extra2() {
		global $_G,$show_message,$_GET;
		$var = $_G['cache']['plugin']['dsu_paulsign'];
		$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
		$allowmem = memory('check');
		if($var['ajax_sign'] && $var['ifopen'] && !$show_message && !defined('IN_dsu_paulsign') && !defined('IN_dsu_paulsc') && !$_GET['infloat'] && !$_G['inajax'] && $_G['uid'] && !in_array($_G['uid'],explode(",",$var['ban'])) && in_array($_G['groupid'], unserialize($var['groups']))) {
			if($allowmem && $var['mcacheopen']) $signtime = memory('get', 'dsu_pualsign_'.$_G['uid']);
			if(!$signtime){
				$qiandaodb = DB::fetch_first("SELECT time FROM ".DB::table('dsu_paulsign')." WHERE uid='$_G[uid]'");
				$htime = dgmdate($_G['timestamp'], 'H',$var['tos']);
				if($qiandaodb){
					if($allowmem && $var['mcacheopen']) memory('set', 'dsu_pualsign_'.$_G['uid'], $qiandaodb['time'], 86400);
					if($qiandaodb['time'] < $tdtime){
						if($var['timeopen']) {
							if(!($htime < $var['stime']) && !($htime > $var['ftime'])) return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'dsu_paulsign\', \'plugin.php?id=dsu_paulsign:sign&'.FORMHASH.'\')"><font color="red">'.lang('plugin/dsu_paulsign','encore_01').'</font></a> ';
						}else{
							return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'dsu_paulsign\', \'plugin.php?id=dsu_paulsign:sign&'.FORMHASH.'\')"><font color="red">'.lang('plugin/dsu_paulsign','encore_01').'</font></a> ';
						}
					}
				}else{
					$ttps = DB::fetch_first("SELECT posts FROM ".DB::table('common_member_count')." WHERE uid='$_G[uid]'");
					if($var['mintdpost'] <= $ttps['posts']){
						if($var['timeopen']) {
							if(!($htime < $var['stime']) && !($htime > $var['ftime'])) return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'dsu_paulsign\', \'plugin.php?id=dsu_paulsign:sign&'.FORMHASH.'\')"><font color="red">'.lang('plugin/dsu_paulsign','encore_01').'</font></a> ';
						}else{
							return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'dsu_paulsign\', \'plugin.php?id=dsu_paulsign:sign&'.FORMHASH.'\')"><font color="red">'.lang('plugin/dsu_paulsign','encore_01').'</font></a> ';
						}
					}
				}
			}else{
				if($signtime < $tdtime){
					if($var['timeopen']) {
						if(!($htime < $var['stime']) && !($htime > $var['ftime'])) return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'dsu_paulsign\', \'plugin.php?id=dsu_paulsign:sign&'.FORMHASH.'\')"><font color="red">'.lang('plugin/dsu_paulsign','encore_01').'</font></a> ';
					}else{
						return '<span class="pipe">|</span><a href="javascript:;" onclick="showWindow(\'dsu_paulsign\', \'plugin.php?id=dsu_paulsign:sign&'.FORMHASH.'\')"><font color="red">'.lang('plugin/dsu_paulsign','encore_01').'</font></a> ';
					}
				}
			}
		}
		return '';
	}
	function global_footer() {
		global $_G,$show_message,$_GET;
		function dsu_signtz() {
			global $_G;
			if(defined('IN_MOBILE')) {
				return '';
			}else{
				if(in_array($_G['groupid'], unserialize($_G['cache']['plugin']['dsu_paulsign']['autosign_ug']))){
					$nfastreplytext =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $_G['cache']['plugin']['dsu_paulsign']['fastreplytext']);
					$fastreplytexts = explode("/hhf/", $nfastreplytext);
					return '<script type="text/javascript">showWindow(\'dsu_paulsign\', \'plugin.php?id=dsu_paulsign:sign&operation=qiandao&formhash='.FORMHASH.'&qdmode=2&fastreply='.array_rand($fastreplytexts,'1').'&qdxq='.array_rand(unserialize($_G['setting']['paulsign_emot']),'1').'\');</script>';
				}else{
					if($_G['cache']['plugin']['dsu_paulsign']['ajax_sign']){
						return '<script type="text/javascript">showWindow(\'dsu_paulsign\', \'plugin.php?id=dsu_paulsign:sign&'.FORMHASH.'\');</script>';
					}else{
						dheader('Location: plugin.php?id=dsu_paulsign:sign');
					}
				}
			}
		}
		$var = $_G['cache']['plugin']['dsu_paulsign'];
		$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
		$allowmem = memory('check');
		if($var['ifopen'] && $var['ftopen'] && !$show_message && !defined('IN_dsu_paulsign') && !defined('IN_dsu_paulsc') && !$_GET['infloat'] && !$_G['inajax'] && $_G['uid'] && (in_array($_G['groupid'], unserialize($var['tzgroupid'])) || in_array($_G['groupid'], unserialize($var['autosign_ug']))) && !in_array($_G['uid'],explode(",",$var['ban'])) && in_array($_G['groupid'], unserialize($var['groups']))) {
			if($allowmem && $var['mcacheopen']) $signtime = memory('get', 'dsu_pualsign_'.$_G['uid']);
			if(!$signtime){
				$qiandaodb = DB::fetch_first("SELECT time FROM ".DB::table('dsu_paulsign')." WHERE uid='$_G[uid]'");
				$htime = dgmdate($_G['timestamp'], 'H',$var['tos']);
				if($qiandaodb){
					if($allowmem && $var['mcacheopen']) memory('set', 'dsu_pualsign_'.$_G['uid'], $qiandaodb['time'], 86400);
					if($qiandaodb['time'] < $tdtime){
						if($var['timeopen']) {
							if(!($htime < $var['stime']) && !($htime > $var['ftime'])) return dsu_signtz();
						}else{
							return dsu_signtz();
						}
					}
				}else{
					$ttps = DB::fetch_first("SELECT posts FROM ".DB::table('common_member_count')." WHERE uid='$_G[uid]'");
					if($var['mintdpost'] <= $ttps['posts']){
						if($var['timeopen']) {
							if(!($htime < $var['stime']) && !($htime > $var['ftime'])) return dsu_signtz();
						}else{
							return dsu_signtz();
						}
					}
				}
			}else{
				if($signtime < $tdtime){
					if($var['timeopen']) {
						if(!($htime < $var['stime']) && !($htime > $var['ftime']))return dsu_signtz();
					}else{
						return dsu_signtz();
					}
				}
			}
		}
		return '';
	}
}
class plugin_dsu_paulsign_home extends plugin_dsu_paulsign {
	function space_profile_baseinfo_bottom() {
		global $_G,$_GET;
		$var = $_G['cache']['plugin']['dsu_paulsign'];
		$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
		if($var['spaceopen']){
			$creditnamecn = $_G['setting']['extcredits'][$var[nrcredit]]['title'];
			$nlvtext =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $var['lvtext']);
			list($lv1name, $lv2name, $lv3name, $lv4name, $lv5name, $lv6name, $lv7name, $lv8name, $lv9name, $lv10name, $lvmastername) = explode("/hhf/", $nlvtext);
			$qiandaodb = DB::fetch_first("SELECT * FROM ".DB::table('dsu_paulsign')." WHERE uid='".intval($_GET['uid'])."'");
			if($qiandaodb){
				$qtime = dgmdate($qiandaodb['time'], 'Y-m-d H:i');
				if ($qiandaodb['days'] >= '1500') {
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.Master]{$lvmastername}</b></font> .";
				} elseif ($qiandaodb['days'] >= '750') {
					$q['lvqd'] = 1500 - $qiandaodb['days'];
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.10]{$lv10name}".lang('plugin/dsu_paulsign','echo_12')."<font color=#FF0000><b>[LV.Master]{$lvmastername}</b></font>".lang('plugin/dsu_paulsign','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/dsu_paulsign','echo_14');
				} elseif ($qiandaodb['days'] >= '365') {
					$q['lvqd'] = 750 - $qiandaodb['days'];
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.9]{$lv9name}</b></font>".lang('plugin/dsu_paulsign','echo_12')."<font color=#FF0000><b>[LV.10]{$lv10name}</b></font>".lang('plugin/dsu_paulsign','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/dsu_paulsign','echo_14');
				} elseif ($qiandaodb['days'] >= '240') {
					$q['lvqd'] = 365 - $qiandaodb['days'];
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.8]{$lv8name}</b></font>".lang('plugin/dsu_paulsign','echo_12')."<font color=#FF0000><b>[LV.9]{$lv9name}</b></font>".lang('plugin/dsu_paulsign','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/dsu_paulsign','echo_14');
				} elseif ($qiandaodb['days'] >= '120') {
					$q['lvqd'] = 240 - $qiandaodb['days'];
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.7]{$lv7name}</b></font>".lang('plugin/dsu_paulsign','echo_12')."<font color=#FF0000><b>[LV.8]{$lv8name}</b></font>".lang('plugin/dsu_paulsign','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/dsu_paulsign','echo_14');
				} elseif ($qiandaodb['days'] >= '60') {
					$q['lvqd'] = 120 - $qiandaodb['days'];
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.6]{$lv6name}</b></font>".lang('plugin/dsu_paulsign','echo_12')."<font color=#FF0000><b>[LV.7]{$lv7name}</b></font>".lang('plugin/dsu_paulsign','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/dsu_paulsign','echo_14');
				} elseif ($qiandaodb['days'] >= '30') {
					$q['lvqd'] = 60 - $qiandaodb['days'];
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.5]{$lv5name}</b></font>".lang('plugin/dsu_paulsign','echo_12')."<font color=#FF0000><b>[LV.6]{$lv6name}</b></font>".lang('plugin/dsu_paulsign','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/dsu_paulsign','echo_14');
				} elseif ($qiandaodb['days'] >= '15') {
					$q['lvqd'] = 30 - $qiandaodb['days'];
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.4]{$lv4name}</b></font>".lang('plugin/dsu_paulsign','echo_12')."<font color=#FF0000><b>[LV.5]{$lv5name}</b></font>".lang('plugin/dsu_paulsign','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/dsu_paulsign','echo_14');
				} elseif ($qiandaodb['days'] >= '7') {
					$q['lvqd'] = 15 - $qiandaodb['days'];
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.3]{$lv3name}</b></font>".lang('plugin/dsu_paulsign','echo_12')."<font color=#FF0000><b>[LV.4]{$lv4name}</b></font>".lang('plugin/dsu_paulsign','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/dsu_paulsign','echo_14');
				} elseif ($qiandaodb['days'] >= '3') {
					$q['lvqd'] = 7 - $qiandaodb['days'];
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.2]{$lv2name}</b></font>".lang('plugin/dsu_paulsign','echo_12')."<font color=#FF0000><b>[LV.3]{$lv3name}</b></font>".lang('plugin/dsu_paulsign','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/dsu_paulsign','echo_14');
				} elseif ($qiandaodb['days'] >= '1') {
					$q['lvqd'] = 3 - $qiandaodb['days'];
					$q['level'] = lang('plugin/dsu_paulsign','echo_11')."<font color=green><b>[LV.1]{$lv1name}</b></font>".lang('plugin/dsu_paulsign','echo_12')."<font color=#FF0000><b>[LV.2]{$lv2name}</b></font>".lang('plugin/dsu_paulsign','echo_13')."<font color=#FF0000><b>{$q['lvqd']}</b></font>".lang('plugin/dsu_paulsign','echo_14');
				}
				$lastedecho = $_G['cache']['plugin']['dsu_paulsign']['lastedop'] ? "<p>".lang('plugin/dsu_paulsign','echo_17')." <b>{$qiandaodb['lasted']}</b> ".lang('plugin/dsu_paulsign','echo_5')."</p>" : '';
				$q['if']= $qiandaodb['time']< $tdtime ? "<span class=gray>".lang('plugin/dsu_paulsign','echo_1')."</span>" : "<font color=green>".lang('plugin/dsu_paulsign','echo_2')."</font>";
				return "<div class='pbm mbm bbda c'><h2 class='mbn'>".lang('plugin/dsu_paulsign','echo_3')."</h2><p>".lang('plugin/dsu_paulsign','echo_4')." <b>{$qiandaodb['days']}</b> ".lang('plugin/dsu_paulsign','echo_5')."</p>".$lastedecho."<p>".lang('plugin/dsu_paulsign','echo_6')." <b>{$qiandaodb['mdays']}</b> ".lang('plugin/dsu_paulsign','echo_5')."</p><p>".lang('plugin/dsu_paulsign','echo_7')." <font color=#ff00cc>{$qtime}</font></p><p>".lang('plugin/dsu_paulsign','echo_15')."{$creditnamecn} <font color=#ff00cc><b>{$qiandaodb['reward']}</b></font> {$_G[setting][extcredits][$var[nrcredit]]['unit']}".lang('plugin/dsu_paulsign','echo_16')."{$creditnamecn} <font color=#ff00cc><b>{$qiandaodb['lastreward']}</b></font> {$_G[setting][extcredits][$var[nrcredit]]['unit']}.</p><p>{$q['level']}</p><p>".lang('plugin/dsu_paulsign','echo_8')."{$q['if']}".lang('plugin/dsu_paulsign','echo_9')."</p></div>";
			}else{
				return "<div class='pbm mbm bbda c'><h2 class='mbn'>".lang('plugin/dsu_paulsign','echo_3')."</h2><p>".lang('plugin/dsu_paulsign','echo_10')."</p></div>";
			}
		}else{
			return "";
		}
	}
}
class plugin_dsu_paulsign_forum extends plugin_dsu_paulsign {
	function viewthread_postbottom_output(){
		global $_G,$postlist,$_GET;
		$authorid_pd = $postlist[$_G["forum_firstpid"]]["authorid"];
		$var = $_G['cache']['plugin']['dsu_paulsign'];
		$tdtime = gmmktime(0,0,0,dgmdate($_G['timestamp'], 'n',$var['tos']),dgmdate($_G['timestamp'], 'j',$var['tos']),dgmdate($_G['timestamp'], 'Y',$var['tos'])) - $var['tos']*3600;
		$lang['classn_03'] = lang('plugin/dsu_paulsign','classn_03');
		$lang['classn_04'] = lang('plugin/dsu_paulsign','classn_04');
		$lang['classn_05'] = lang('plugin/dsu_paulsign','classn_05');
		$lang['classn_06'] = lang('plugin/dsu_paulsign','classn_06');
		$lang['classn_07'] = lang('plugin/dsu_paulsign','classn_07');
		$lang['classn_08'] = lang('plugin/dsu_paulsign','classn_08');
		$lang['classn_09'] = lang('plugin/dsu_paulsign','classn_09');
		$lang['classn_10'] = lang('plugin/dsu_paulsign','classn_10');
		$open = $_G['cache']['plugin']['dsu_paulsign']['tidphopen'];
		if($open){
			$qdtype = $_G['cache']['plugin']['dsu_paulsign']['qdtype'];
			if($qdtype == 2){
				$qdtidnumber = $_G['cache']['plugin']['dsu_paulsign']['tidnumber'];
			} elseif($qdtype == 3){
				$stats = DB::fetch_first("SELECT qdtidnumber FROM ".DB::table('dsu_paulsignset')." WHERE id='1'");
				$qdtidnumber = $stats['qdtidnumber'];
			}else{
				$qdtidnumber = 0;
			}
			if(($qdtidnumber == $_GET['tid']) && $authorid_pd){
				$pnum = $_G['cache']['plugin']['dsu_paulsign']['tidpnum'];
				$nrcredit = $_G['cache']['plugin']['dsu_paulsign']['nrcredit'];
				$nlvtext =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $_G['cache']['plugin']['dsu_paulsign']['lvtext']);
				list($lv1name, $lv2name, $lv3name, $lv4name, $lv5name, $lv6name, $lv7name, $lv8name, $lv9name, $lv10name, $lvmastername) = explode("/hhf/", $nlvtext);
				$query = DB::query("SELECT q.days,q.time,q.uid,q.lastreward,m.username FROM ".DB::table('dsu_paulsign')." q, ".DB::table('common_member')." m WHERE q.uid=m.uid and q.time > {$tdtime} ORDER BY q.time LIMIT 0,{$pnum}");
				$mrcs = array();
				$i = 1;
				while($mrc = DB::fetch($query)) {
					$mrc['time'] = dgmdate($mrc['time'], 'Y-m-d H:i');
					if ($mrc['days'] >= '1500') {
			  			$mrc['level'] = "[LV.Master]{$lvmastername}";
					} elseif ($mrc['days'] >= '750') {
			  			$mrc['level'] = "[LV.10]{$lv10name}";
					} elseif ($mrc['days'] >= '365') {
			  			$mrc['level'] = "[LV.9]{$lv9name}";
					} elseif ($mrc['days'] >= '240') {
			  			$mrc['level'] = "[LV.8]{$lv8name}";
					} elseif ($mrc['days'] >= '120') {
			  			$mrc['level'] = "[LV.7]{$lv7name}";
					} elseif ($mrc['days'] >= '60') {
			  			$mrc['level'] = "[LV.6]{$lv6name}";
					} elseif ($mrc['days'] >= '30') {
			  			$mrc['level'] = "[LV.5]{$lv5name}";
					} elseif ($mrc['days'] >= '15') {
			  			$mrc['level'] = "[LV.4]{$lv4name}";
					} elseif ($mrc['days'] >= '7') {
			  			$mrc['level'] = "[LV.3]{$lv3name}";
					} elseif ($mrc['days'] >= '3') {
			  			$mrc['level'] = "[LV.2]{$lv2name}";
					} elseif ($mrc['days'] >= '1') {
			  			$mrc['level'] = "[LV.1]{$lv1name}";
					}
			 		$mrcs[$i++] = $mrc;
				}
				include template('dsu_paulsign:sign_list');
				return array(0=>$return);
			}else{
				return array();
			}
		}else{
		  return array();
		}
	}
	function viewthread_sidetop_output() {
		global $postlist,$_G,$_GET;
		$open = $_G['cache']['plugin']['dsu_paulsign']['sidebarmode'];
		$lastedop = $_G['cache']['plugin']['dsu_paulsign']['lastedop'];
		if(empty($_GET['tid']) || !is_array($postlist) || !$open) return array();
		$emots = unserialize($_G['setting']['paulsign_emot']);
		$pids=array_keys($postlist);
		$authorids=array();
		foreach($postlist as $pid=>$pinfo){
			$authorids[]=$pinfo['authorid'];
		}
		$authorids = array_unique($authorids);
		$authorids = array_filter($authorids);
		$authorids = dimplode($authorids);
		if($authorids == '') return array();
		$uidlists = DB::query("SELECT uid,days,lasted,qdxq,time FROM ".DB::table('dsu_paulsign')." WHERE uid IN($authorids)");
		$days = array();
		$nlvtext =str_replace(array("\r\n", "\n", "\r"), '/hhf/', $_G['cache']['plugin']['dsu_paulsign']['lvtext']);
		list($lv1name, $lv2name, $lv3name, $lv4name, $lv5name, $lv6name, $lv7name, $lv8name, $lv9name, $lv10name, $lvmastername) = explode("/hhf/", $nlvtext);
		while($mrc = DB::fetch($uidlists)) {
			$days[$mrc['uid']]['days'] = $mrc['days'];
			if(!array_key_exists($mrc['qdxq'],$emots)) {
				$mrc['qdxq'] = end(array_keys($emots));
			}
			$days[$mrc['uid']]['qdxq'] = $mrc['qdxq'];
			$days[$mrc['uid']]['time'] = dgmdate($mrc['time'], 'u');
			if ($lastedop) $days[$mrc['uid']]['lasted'] = $mrc['lasted'];
			if ($mrc['days'] >= '1500') {
				$days[$mrc['uid']]['level'] = "[LV.Master]{$lvmastername}";
			} elseif ($mrc['days'] >= '750') {
			  	$days[$mrc['uid']]['level'] = "[LV.10]{$lv10name}";
			} elseif ($mrc['days'] >= '365') {
			  	$days[$mrc['uid']]['level'] = "[LV.9]{$lv9name}";
			} elseif ($mrc['days'] >= '240') {
			  	$days[$mrc['uid']]['level'] = "[LV.8]{$lv8name}";
			} elseif ($mrc['days'] >= '120') {
			  	$days[$mrc['uid']]['level'] = "[LV.7]{$lv7name}";
			} elseif ($mrc['days'] >= '60') {
			  	$days[$mrc['uid']]['level'] = "[LV.6]{$lv6name}";
			} elseif ($mrc['days'] >= '30') {
			  	$days[$mrc['uid']]['level'] = "[LV.5]{$lv5name}";
			} elseif ($mrc['days'] >= '15') {
			  	$days[$mrc['uid']]['level'] = "[LV.4]{$lv4name}";
			} elseif ($mrc['days'] >= '7') {
			  	$days[$mrc['uid']]['level'] = "[LV.3]{$lv3name}";
			} elseif ($mrc['days'] >= '3') {
			  	$days[$mrc['uid']]['level'] = "[LV.2]{$lv2name}";
			} elseif ($mrc['days'] >= '1') {
				$days[$mrc['uid']]['level'] = "[LV.1]{$lv1name}";
			}
			$days[$mrc['uid']]['qdxqzw'] = $emots[$mrc['qdxq']]['name'];
			$days[] = $mrc;
		}
		$echoq = array();
		foreach($postlist as $key => $val) {
			if($days[$postlist[$key][authorid]][days]) {
				$lastedecho = $lastedop ? '<p>'.lang('plugin/dsu_paulsign','classn_12').': '.$days[$postlist[$key][authorid]][lasted].' '.lang('plugin/dsu_paulsign','classn_02').'</p>' : '';
				if($open == '2')$echoonce = '<div class="qdsmile"><li><center>'.lang('plugin/dsu_paulsign','ta_mind').'</center><table><tr><th><img src="source/plugin/dsu_paulsign/img/emot/'.$days[$postlist[$key][authorid]][qdxq].'.gif"><th><font size="5px">'.$days[$postlist[$key][authorid]][qdxqzw].'</font><br>'.$days[$postlist[$key][authorid]][time].'</tr></table></li></div>';
				$echoonce .= '<p>'.lang('plugin/dsu_paulsign','classn_01').': '.$days[$postlist[$key][authorid]][days].' '.lang('plugin/dsu_paulsign','classn_02').'</p>'.$lastedecho.'<p>'.$days[$postlist[$key][authorid]][level].'</p>';
			} else {
				$echoonce = '<p>'.lang('plugin/dsu_paulsign','classn_11').'</p>';
			}
			$echoq[] = $echoonce;
			$echoonce = '';
		}
		return $echoq;
	}
}
?>