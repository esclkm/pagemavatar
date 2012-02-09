<?php

/**
 * Pagemultiavatar for Cotonti CMF
 *
 * @version 2.00
 * @author  esclkm, graber
 * @copyright (c) 2011 esclkm, graber
 */
defined('COT_CODE') or die('Wrong URL');

global $db_mav, $mav_opts, $mav_struct, $mav_sets, $R;

$db_mav = 'cot_pagemavatar';
require_once cot_incfile('pagemavatar', 'plug', 'resources');


$tpaset = str_replace("\r\n", "\n", $cfg['plugin']['pagemavatar']['set']);
$tpaset = explode("\n", $tpaset);
foreach ($tpaset as $val)
{
	$val = explode('|', $val);
	$val = array_map('trim', $val);
	if (!empty($val[0]))
	{
		$thumbs = array();
		if (!empty($val[2]) > 0)
		{
			$varfields = explode(' ', $val[2]);
			foreach ($varfields as $val2)
			{
				$val2 = explode('-', $val2);
				$val2[3] = (!in_array($val2[3], array('crop', 'height', 'width'))) ? 'auto' : $val2[3];
				$thumbs[$val2[0]] = array('x' => (int) $val2[1], 'y' => (int) $val2[2], 'set' => $val2[3]);
			}
		}

		$val[1] = (!empty($val[1])) ? $val[1] : 'datas/photos';
		$val[1] .= (substr($val[1], -1) == '/') ? '' : '/';
		$mav_sets[$val[0]] = array(
			'path' => $val[1],
			'thumbs' => $thumbs,
			'req' => (int) $val[3] ? 1 : 0,
			'ext' => (!empty($val[4])) ? explode(' ', $val[4]) : array('jpg', 'jpeg', 'png', 'gif'),
			'max' => ((int) $val[5] > 0) ? $val[5] : 0
		);
	}
}
if (!$mav_sets['all'])
{
	$mav_sets['all'] = array(
		'path' => 'datas/photos/',
		'thumbs' => array(),
		'req' => 0,
		'ext' => array('jpg', 'jpeg', 'png', 'gif'),
		'max' => 0
	);
}

$mav_catp = cot_import('rpagecat', 'P', 'TXT');
$mav_catp_p = cot_structure_parents('page', $mav_catp, 'first');
$mav_opts = ($mav_sets[$mav_catp_p]) ? $mav_sets[$mav_catp_p] : $mav_sets['all'];
$mav_opts = ($mav_sets[$mav_catp]) ? $mav_sets[$mav_catp] : $mav_opts;

function cot_mavreset($cat)
{

	global $mav_sets;
	$mav_catp_p = cot_structure_parents('page', $cat, 'first');
	$mav_opts = ($mav_sets[$mav_catp_p]) ? $mav_sets[$mav_catp_p] : $mav_sets['all'];
	$mav_opts = ($mav_sets[$cat]) ? $mav_sets[$cat] : $mav_opts;
	return($mav_opts);
}

function cot_getpagemavatars($page_id, $forcibly = false)
{
	global $db, $db_mav, $cfg;
	static $mav_struct;
	if (!isset($mav_struct[$page_id]) || $forcibly)
	{
		unset($mav_struct[$page_id]);
		$mav_struct[$page_id] = array();
		$mav_sql = $db->query("SELECT * FROM $db_mav WHERE mav_pid = " . (int) $page_id . " ORDER BY mav_item");
		while ($mav_row = $mav_sql->fetch())
		{
			$mav_struct[$mav_row['mav_pid']][$mav_row['mav_item']]['path'] = $mav_row['mav_path'];
			$mav_struct[$mav_row['mav_pid']][$mav_row['mav_item']]['desc'] = $mav_row['mav_desc'];
			$mav_struct[$mav_row['mav_pid']][$mav_row['mav_item']]['key'] = $mav_row['mav_key'];
		}
	}
	return $mav_struct[$page_id];
}

function cot_checkemptyrow($i, $mav_files)
{
	while (isset($mav_files[$i]))
	{
		$i++;
	}
	return($i);
}

function cot_mav_upload($id, $mav_data, $mav_paset, $mav_desc = array(), $mav_key = array())
{
	global $db, $db_mav, $usr, $mav_struct;
	$mav_files = cot_getpagemavatars($id, true);

	$mav_desc = is_array($mav_desc) ? $mav_desc : array();
	$mav_key = is_array($mav_key) ? $mav_key : array();
	if (is_array($mav_data['name']))
	{
		$i = 1;
		foreach ($mav_data['name'] as $key => $val)
		{
			if (!empty($val))
			{
				//$i = cot_checkemptyrow($i, $mav_files);
				//echo "NEED UPLOAD $i\n";
				$mav_data['file_ext'][$key] = mb_strtolower(end(explode(".", $val)));

				$filename = str_replace('.' . $mav_data['file_ext'][$key], '', $val);

				$mav_pafname = "page_" . $id . "_" . $i . "." . $mav_data['file_ext'][$key];
				$mav_filename = $mav_paset['path'] . $mav_pafname;
				if (file_exists($mav_filename))
				{
					@unlink($mav_filename);
				}
				$db->delete($db_mav, "mav_pid=$id AND mav_item=$i");

				$desc = cot_import($mav_desc[$key], 'D', 'TXT');
				$mavkey = cot_import($mav_key[$key], 'D', 'TXT');

				move_uploaded_file($mav_data['tmp_name'][$key], $mav_filename);
				$mav_dbdata = array(
					'mav_pid' => $id,
					'mav_uid' => $usr['id'],
					'mav_item' => $i,
					'mav_path' => $mav_pafname,
					'mav_desc' => (!empty($desc)) ? $desc : $filename,
					'mav_key' => $mavkey
				);
				$db->insert($db_mav, $mav_dbdata);
				if (file_exists($mav_filename) && in_array($mav_data['file_ext'][$key], array('jpg', 'jpeg', 'png', 'gif')))
				{
					foreach ($mav_paset['thumbs'] as $key => $val)
					{
						$mav_newfname = $mav_paset['path'] . $key . $mav_pafname;
						if (file_exists($mav_newfname))
						{
							@unlink($mav_newfname);
						}
						cot_thumb($mav_filename, $mav_newfname, $val['x'], $val['y'], $val['set']);
					}
				}
			}
			$i++;
		}
	}
}

if (!function_exists(cot_thumb))
{

	/**
	 * Creates image thumbnail
	 *
	 * @param string $source Original image path
	 * @param string $target Thumbnail path
	 * @param int $width Thumbnail width
	 * @param int $height Thumbnail height
	 * @param string $resize resize options: crop auto width height
	 * @param int $quality JPEG quality in %
	 */
	function cot_thumb($source, $target, $width, $height, $resize = 'crop', $quality = 85)
	{
		$ext = strtolower(pathinfo($source, PATHINFO_EXTENSION));
		list($width_orig, $height_orig) = getimagesize($source);
		$x_pos = 0;
		$y_pos = 0;
		
		$width =  (mb_substr($width, -1, 1) == '%') ? (int)($width_orig * (int)mb_substr($width, 0, -1) / 100) : (int)$width;
		$height =  (mb_substr($height, -1, 1) == '%') ? (int)($height_orig * (int)mb_substr($height, 0, -1) / 100) : (int)$height;

		if ($resize == 'crop')
		{
			$newimage = imagecreatetruecolor($width, $height);
			$width_temp = $width;
			$height_temp = $height;

			if ($width_orig / $height_orig > $width / $height)
			{
				$width = $width_orig * $height / $height_orig;
				$x_pos = -($width - $width_temp) / 2;
				$y_pos = 0;
			}
			else
			{
				$height = $height_orig * $width / $width_orig;
				$y_pos = -($height - $height_temp) / 2;
				$x_pos = 0;
			}
		}
		else
		{
			if ($resize == 'width' || $height == 0)
			{
				if ($width_orig > $width)
				{
					$height = $height_orig * $width / $width_orig;
				}
				else
				{
					$width = $width_orig;
					$height = $height_orig;
				}
			}
			elseif ($resize == 'height' || $width == 0)
			{
				if ($height_orig > $height)
				{
					$width = $width_orig * $height / $height_orig;
				}
				else
				{
					$width = $width_orig;
					$height = $height_orig;
				}
			}
			elseif ($resize == 'auto')
			{
				if ($width_orig < $width && $height_orig < $height)
				{
					$width = $width_orig;
					$height = $height_orig;
				}
				else
				{
					if ($width_orig / $height_orig > $width / $height)
					{
						$height = $width * $height_orig / $width_orig;
					}
					else
					{
						$width = $height * $width_orig / $height_orig;
					}
				}
			}


			$newimage = imagecreatetruecolor($width, $height); //
		}

		switch ($ext)
		{
			case 'gif':
				$oldimage = imagecreatefromgif($source);
				break;
			case 'png':
				imagealphablending($newimage, false);
				imagesavealpha($newimage, true);
				$oldimage = imagecreatefrompng($source);
				break;
			default:
				$oldimage = imagecreatefromjpeg($source);
				break;
		}

		imagecopyresampled($newimage, $oldimage, $x_pos, $y_pos, 0, 0, $width, $height, $width_orig, $height_orig);

		switch ($ext)
		{
			case 'gif':
				imagegif($newimage, $target);
				break;
			case 'png':
				imagepng($newimage, $target);
				break;
			default:
				imagejpeg($newimage, $target, $quality);
				break;
		}

		imagedestroy($newimage);
		imagedestroy($oldimage);
	}

}
?>