<?php

/**
 * [BEGIN_COT_EXT]
 * Hooks=page.add.tags
 * Tags=page.add.tpl:{PAGEADD_FORM_MAVATARTITLE}, {PAGEADD_FORM_MAVATAR}
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

for ($i = 0; $i < $cfg['plugin']['pagemavatar']['items']; ++$i)
{
	$t->assign(array(
		'PAGEADD_FORM_MAVATARTITLE' => $L['mavatar_file']." ".$i,
		'PAGEADD_FORM_MAVATAR' => cot_inputbox('file', 'pagemavaar[]', '', 'class="file" size="56"', 'pagemavatar_input_file')
	));
	$t->parse('MAIN.PAGEMAVATAR_ROW');
}
$t->assign(array(
	'PAGEADD_FORM_MAVATAR' => '<div class="pagemavatarfileblock">'.cot_inputbox('file', 'pagemavatar[]', '', 'class="file" id="pagemavatarfile" size="56"', 'pagemavatar_input_file').'
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