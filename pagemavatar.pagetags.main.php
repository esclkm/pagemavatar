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
			$tempmav['FILE'] = $filename;
			$tempmav['PATH'] = $val['path'];
			$tempmav['DESC'] = $val['desc'];
			$tempmav['KEY'] = $val['key'];
			$tempmav['NUM'] = $ji;

			foreach ($mav_opts['thumbs'] as $a_key => $a_val)
			{
				$newfilename = $mav_opts['path'].$a_key.$val['path'];
				// try to Add if not exists 
				if (!file_exists($newfilename))
				{
					cot_thumb($filename, $newfilename, $a_val['x'], $a_val['y'], $a_val['set']);
				}
				//
				$newfilename = file_exists($newfilename) ? $newfilename : '';

				$tempmav[mb_strtoupper($a_key)] = $newfilename;
			}
		}
		$temp_array['MAVATAR'][$ji] = $tempmav;
	}
	$temp_array['MAVATARCOUNT'] = $ji;
}
else
{
	$temp_array['MAVATAR'] = '';
	$temp_array['MAVATARCOUNT'] = 0;
}
?>
