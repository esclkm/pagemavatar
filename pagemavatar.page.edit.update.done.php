<?php
/* 
 * [BEGIN_COT_EXT]
 * Hooks=page.edit.update.done
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
        $mav_del = cot_import('rpagemavatardelete', 'P', 'ARR');
		$mav_files = cot_getpagemavatars($id, true);
		foreach($mav_del as $key => $val)
        {
            if ($val)
            {
                $mav_filename = $mav_opts['path'].$mav_files[$key]['path'];
                if (file_exists($mav_filename))
                {
                    @unlink($mav_filename);
                }
                $db->delete($db_mav, "mav_pid=$id AND mav_item=$key");
                foreach ($mav_opts['thumbs'] as $a_key => $a_val)
                {
                    $mav_newfname = $mav_opts['path'].$a_key.$mav_files[$key]['path'];
                    if (file_exists($mav_newfname))
                    {
                        @unlink($mav_newfname);
                    }
                }
            }
        }

        // Upload new images
        cot_mav_upload($id, $_FILES['pagemavatar'], $mav_opts);
    }
?>
