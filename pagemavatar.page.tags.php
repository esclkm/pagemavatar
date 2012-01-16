<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.tags
 * Tags=page.tpl:{PAGE_MAVATARFILE}
 * [END_COT_EXT]
 */
/**
 * Pagemultiavatar for Cotonti CMF
 *
 * @version 2.00
 * @author  esclkm, graber
 * @copyright (c) 2011 esclkm, graber
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('pagemavatar', 'plug');
$mav_files = cot_getpagemavatars($id);
$ji = 0;
$mav_opts = cot_mavreset($pag['page_cat']);

foreach ($mav_files as $key => $val)
{
	$filename = $mav_opts['path'].$val['path'];
	if (!empty($val['path']) && file_exists($filename))
	{
		
		$ji++;
		$t->assign(array(
			'PAGE_SLIDER_MAVATAR' => $filename,
			'PAGE_SLIDER_MAVATARFILE' => $val['path'],
			'PAGE_SLIDER_MAVATARDESC' => $val['desc'],
			'PAGE_SLIDER_MAVATARNUM' => $ji,
		));

		foreach ($mav_opts['thumbs'] as $a_key => $a_val)
		{
			$newfilename = $mav_opts['path'].$a_key.$val['path'];
			$newfilename = file_exists($newfilename) ? $newfilename : '';

			$t->assign(array(
				'PAGE_SLIDER_'.mb_strtoupper($a_key).'_MAVATAR' => $newfilename
			));
		}
		$t->parse('MAIN.PAGEMAVATAR_ROW');
	}
}
?>