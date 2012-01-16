<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.edit.tags
 * Tags=page.edit.tpl:{PAGEEDIT_FORM_MAVATARTITLE}, {PAGEEDIT_FORM_MAVATARFILE}, {PAGEEDIT_FORM_MAVATAR}, {PAGEEDIT_FORM_MAVATARDELETE}
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

require_once cot_langfile('pagemavatar');
require_once cot_incfile('pagemavatar', 'plug');
$mav_files = cot_getpagemavatars($id);
$i = 1;
foreach ($mav_files as $key => $val)
{
	$mav_file = (isset($mav_files[$key]['path']) ? $mav_files[$key]['path'] : '');

	$t->assign(array(
		'PAGEEDIT_FORM_MAVATARTITLE' => $L['mavatar_file']." ".$i,
		'PAGEEDIT_FORM_MAVATARDESC' => $mav_files[$key]['desc'],
		'PAGEEDIT_FORM_MAVATARFILE' => $mav_file,
		'PAGEEDIT_FORM_MAVATAR' => cot_inputbox('file', 'pagemavatar['.$key.']', '', 'class="file" size="56"', 'pagemavatar_input_file'),
		'PAGEEDIT_FORM_MAVATARDELETE' => cot_radiobox(0, 'rpagemavatardelete['.$key.']', array(1, 0), array($L['Yes'], $L['No']))
	));
	$t->parse('MAIN.PAGEMAVATAR_ROW');
	$i++;
}
for (; $i < $cfg['plugin']['pagemavatar']['items']; $i++)
{
	$t->assign(array(
		'PAGEEDIT_FORM_MAVATARTITLE' => $L['mavatar_file']." ".$i,
		'PAGEEDIT_FORM_MAVATAR' => cot_inputbox('file', 'pagemavatar[]', '', 'class="file" size="56"', 'pagemavatar_input_file'),
		'PAGEEDIT_FORM_MAVATARDESC' => '',
		'PAGEEDIT_FORM_MAVATARFILE' => '',
		'PAGEEDIT_FORM_MAVATARDELETE' => ''
		
	));
	$t->parse('MAIN.PAGEMAVATAR_ROW');
}
$t->assign(array(
	'PAGEEDIT_FORM_MAVATAR' => '<div class="pagemavatarfileblock">'.cot_inputbox('file', 'pagemavatar[]', '', 'class="file" id="pagemavatarfile" size="56"').'
<button name="deloptionfile" type="button" class="deloptionfile" title="'.$L['Delete'].'" style="display:none;">'.$L['Delete'].'</button></div>		
<button id="addoptionfile" name="addoptionfile" type="button" title="'.$L['Add'].'" style="display:none;">'.$L['Add'].'</button>
<script type="text/javascript">
$(".deloptionfile").live("click",function () {
	if ($(".pagemavatarfileblock").length > 1)
	{
		$(this).parent().remove();
	}
	return false;
});

$(document).ready(function(){
	$("#addoptionfile").click(function () {
	$(".pagemavatarfileblock").last().clone().insertAfter($(".pagemavatarfileblock").last()).show().children("input").attr("value","");
	return false;
	});
	$("#addoptionfile").show();
	$(".deloptionfile").show();
});
</script>'
));

?>