<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.add.add.done
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
	cot_mav_upload($id, $_FILES['pagemavatar'], $mav_opts);
}
?>
