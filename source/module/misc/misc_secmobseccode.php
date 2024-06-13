<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id$
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if($_GET['action'] == 'send') {

	$refererhost = parse_url($_SERVER['HTTP_REFERER']);
	$refererhost['host'] .= !empty($refererhost['port']) ? (':'.$refererhost['port']) : '';

	if($refererhost['host'] != $_SERVER['HTTP_HOST']) {
		showmessage('submit_invalid');
	}

	$svctype = empty($_GET['svctype']) ? 0 : $_GET['svctype'];
	$secmobicc = empty($_GET['secmobicc']) ? $_G['member']['secmobicc'] : $_GET['secmobicc'];
	$secmobile = empty($_GET['secmobile']) ? $_G['member']['secmobile'] : $_GET['secmobile'];
	list($seccodecheck, $secqaacheck) = seccheck('card');

	if((!$seccodecheck && !$secqaacheck) || submitcheck('seccodesubmit', 0, $seccodecheck, $secqaacheck)) {
		$length = $_G['setting']['smsdefaultlength'] ? $_G['setting']['smsdefaultlength'] : 4;
		$secmobseccode = random($length, 1);

		if(empty($secmobicc) || !preg_match('#^(\d){1,3}$#', $secmobicc)) {
			showmessage('profile_secmobicc_illegal');
		} else if(empty($secmobile) || !preg_match('#^(\d){1,12}$#', $secmobile)) {
			showmessage('profile_secmobile_illegal');
		}

		$result = sms::send($_G['uid'], 0, $svctype, $secmobicc, $secmobile, $secmobseccode, 0);

		if($result >= 0) {
			showmessage('secmobseccode_send_success', '', array(), array('alert' => 'right'));
		} else {
			if($result <= -1 && $result >= -9) {
				showmessage('secmobseccode_send_err_'.abs($result));
			} else {
				showmessage('secmobseccode_send_failure');
			}
		}
	} else {
		$handlekey = 'sendsecmobseccode';
		include template('common/secmobseccode');
	}

}