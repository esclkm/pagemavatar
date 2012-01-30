<?php

/**
 * Pagemultiavatar for Cotonti CMF
 *
 * @version 2.00
 * @author  esclkm, graber
 * @copyright (c) 2011 esclkm, graber
 */
defined('COT_CODE') or die('Wrong URL');

$R['pagemavatar_input_file'] = '<a href="{$filepath}">{$value}</a><br /><input type="file" name="{$name}" {$attrs} />';

$R['pagemavatar_add_ajax'] = '<div class="pagemavatarfileblock">{$input_file}'.$L['Description'].': {$input_desc} '.$L['Key'].': {$input_keys}
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
</script>';

?>