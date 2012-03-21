<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.add.add.done,page.edit.update.done
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

if (!cot_error_found())
{
	// Delete images
	$mav_del = cot_import('pagemavatardelete', 'P', 'ARR');
	$mav_keys = cot_import('pagemavatarkey', 'P', 'ARR');
	$mav_descs = cot_import('pagemavatardesc', 'P', 'ARR');
	cot_mav_upload($id, $_FILES['pagemavatar'], $mav_opts, $mav_descs, $mav_keys, $mav_del);
	
}

?>