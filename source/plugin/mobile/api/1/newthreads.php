<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: newthreads.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}

include_once 'forum.php';

class mobile_api {

	public static function common() {
		global $_G;
		require_once libfile('function/post');
		$start = !empty($_GET['start']) ? $_GET['start'] : 0;
		$limit = !empty($_GET['limit']) ? $_GET['limit'] : 20;
		$variable['data'] = C::t('forum_newthread')->fetch_all_by_fids(dintval(explode(',', $_GET['fids']), true), $start, $limit);
		foreach(C::t('forum_thread')->fetch_all_by_tid(array_keys($variable['data']), 0, $limit) as $thread) {
			$thread['dbdateline'] = $thread['dateline'];
			$thread['dblastpost'] = $thread['lastpost'];
			$thread['dateline'] = dgmdate($thread['dateline'], 'u');
			$thread['lastpost'] = dgmdate($thread['lastpost'], 'u');
			$tid = $thread['tid'];
			$firstpost = C::t('forum_post')->fetch_threadpost_by_tid_invisible($thread['tid']);
			if($thread['readperm'] < $_G['group']['readaccess']  && $firstpost['invisible'] == 0) {
				$firstPostMessage = $firstpost['message'];
				preg_match_all('/\[attach\](\d+)\[\/attach\]/i', $firstPostMessage, $matches, PREG_SET_ORDER);
				$thread['attachmentImageNumber'] = count($matches);
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
				$thread['attachmentImagePreviewList'] = $attachmentImageList;
				$attach_words = '['.lang('forum/misc', 'attach_img').']';
				$attach_img_text = lang('forum/misc', 'attach_img');
				$attach_words = '['.$attach_img_text.']';
				$firstPostMessage = preg_replace('/\[attach\](\d+)\[\/attach\]/i', $attach_words, $firstPostMessage);
				$firstPostMessage = preg_replace('/<\/*.*?>|&nbsp;|\r\n|\[attachimg\].*?\[\/attachimg\]|\[quote\].*?\[\/quote\]|\[(?!'.$attach_words.')\/*.*?\]/ms', '', $firstPostMessage);
				$firstPostMessage = trim(threadmessagecutstr($thread, $firstPostMessage, 500));
				$thread['message'] = $firstPostMessage;
				$variable['data'][$thread['tid']] = mobile_core::getvalues($thread, array('tid', 'author', 'authorid', 'subject', 'subject', 'dbdateline', 'dateline', 'dblastpost', 'lastpost', 'lastposter', 'attachment', 'replies', 'readperm', 'views', 'digest', 'message', 'attachmentImageNumber', 'attachmentImagePreviewList'));
			}
		}
		$variable['data'] = array_values($variable['data']);
		mobile_core::result(mobile_core::variable($variable));
	}

	public static function output() {}

}

?>