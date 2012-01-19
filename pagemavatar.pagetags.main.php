<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=pagetags.main
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

global $mav_opts, $mav_struct;

$mav_files = cot_getpagemavatars($page_data['page_id']);

$ji = 0;
$mav_opts = cot_mavreset($page_data['page_cat']);
if (count($mav_files))
{
	foreach ($mav_files as $key => $val)
	{
		$filename = $mav_opts['path'].$val['path'];
		if (!empty($val['path']) && file_exists($filename))
		{
			$ji++;
			$temp_array['MAVATAR'][$ji] = $filename;
			$temp_array['MAVATARFILE'][$ji] = $val['path'];
			$temp_array['MAVATARDESC'][$ji] = $val['desc'];
			$temp_array['MAVATARNUM'][$ji] = $ji;

			foreach ($mav_opts['thumbs'] as $a_key => $a_val)
			{
				$newfilename = $mav_opts['path'].$a_key.$val['path'];
				$newfilename = file_exists($newfilename) ? $newfilename : '';

				$temp_array[mb_strtoupper($a_key).'_MAVATAR'][$ji] = $newfilename;
			}
		}
	}
	$temp_array['MAVATARCOUNT'] = count($mav_files);
}
else
{
	$temp_array['MAVATAR'] = '';
	$temp_array['MAVATARFILE'] = '';
	$temp_array['MAVATARDESC'] = '';
	$temp_array['MAVATARNUM'] = '';
	$temp_array['MAVATARCOUNT'] = 0;
	foreach ($mav_opts['thumbs'] as $a_key => $a_val)
	{
		$temp_array[mb_strtoupper($a_key).'_MAVATAR'][$ji] = '';
	}
}
?>
