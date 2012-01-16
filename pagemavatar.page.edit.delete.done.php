<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.edit.delete.done
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
$mav_files = cot_getpagemavatars($id, true);
if (is_array($mav_files))
{
	foreach ($mav_files as $key => $val)
	{
		$mav_file = (isset($mav_files[$key]['path']) ? $mav_files[$key]['path'] : '');
		$mav_filename = $mav_opts['path'].$mav_file;
		if (file_exists($mav_filename))
		{
			@unlink($mav_filename);
		}
		foreach ($mav_opts['thumbs'] as $a_key => $a_val)
		{
			$mav_newfname = $mav_opts['path'].$a_key.$mav_file;
			if (file_exists($mav_newfname))
			{
				@unlink($mav_newfname);
			}
		}
		$db->delete($db_mav, "mav_pid=$id AND mav_item=$key");
	}
}
?>
