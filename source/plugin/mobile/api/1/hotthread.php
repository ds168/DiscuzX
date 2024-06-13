<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: hotthread.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

$_GET['mod'] = 'guide';
$_GET['view'] = 'hot';
include_once 'forum.php';

class mobile_api {

	public static function common() {
	}

	public static function output() {
		global $_G;

		require_once libfile('function/post');
		foreach($GLOBALS['data']['hot']['threadlist'] as $tid=>$thread) {
			$GLOBALS['data']['hot']['threadlist'][$tid]['avatar'] = avatar($thread['authorid'], 'big', true);
			$firstpost = C::t('forum_post')->fetch_threadpost_by_tid_invisible($thread['tid']);
			if($thread['readperm'] < $_G['group']['readaccess']  && $firstpost['invisible'] == 0) {
				$firstPostMessage = $firstpost['message'];
				preg_match_all('/\[attach\](\d+)\[\/attach\]/i', $firstPostMessage, $matches, PREG_SET_ORDER);
				$GLOBALS['data']['hot']['threadlist'][$tid]['attachmentImageNumber'] = count($matches);
				$cnt = 0;
				$aidList = array();
				foreach ($matches as $i => $match) {
					if ($cnt > 3) {
						break;
					}
					$cnt += 1;
					$aidList[] = $match[1];
				}
				$attachmentImageList = array();
				$attachments = C::t('forum_attachment')->fetch_all($aidList);
				foreach ($attachments as $aid => $attach) {
					$attachment = C::t('forum_attachment_n')->fetch_attachment($attach["tableid"], $attach["aid"], true);
					$attachmentImageList[] = $attachment;
				}
				$GLOBALS['data']['hot']['threadlist'][$tid]['attachmentImagePreviewList'] = $attachmentImageList;
				$attach_img_text = lang('forum/misc', 'attach_img');
				$attach_words = '['.$attach_img_text.']';
				$firstPostMessage = preg_replace('/\[attach\](\d+)\[\/attach\]/i', $attach_words, $firstPostMessage);
				$firstPostMessage = preg_replace('/<\/*.*?>|&nbsp;|\r\n|\[attachimg\].*?\[\/attachimg\]|\[quote\].*?\[\/quote\]|\[(?!'.$attach_words.')\/*.*?\]/ms', '', $firstPostMessage);
				$firstPostMessage = trim(threadmessagecutstr($thread, $firstPostMessage, 500));
				$GLOBALS['data']['hot']['threadlist'][$tid]['message'] = $firstPostMessage;
			}
		}
		$variable = array(
			'data' => array_values($GLOBALS['data']['hot']['threadlist']),
			'perpage' => $GLOBALS['perpage'],
		);
		mobile_core::result(mobile_core::variable($variable));
	}

}

?>