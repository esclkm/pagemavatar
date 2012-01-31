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
		'PAGEADD_FORM_MAVATARTITLE' => $L['mavatar_file'] . " " . $i,
		'PAGEADD_FORM_MAVATAR' => cot_inputbox('file', 'pagemavaar[]', '', 'class="file" size="20"', 'pagemavatar_input_file'),
		'PAGEADD_FORM_MAVATARDESC_INPUT' => cot_inputbox('text', 'pagemavatardesc[]', '', 'class="desc" size="20"'),
		'PAGEADD_FORM_MAVATARKEY_INPUT' => cot_inputbox('text', 'pagemavatarkey[]', '', 'class="key" size="20"'),
	));
	$t->parse('MAIN.PAGEMAVATAR_ROW');
}
$t->assign(array(
	'PAGEADD_FORM_MAVATAR' => cot_rc('pagemavatar_add_ajax', array(
		'input_file' => cot_inputbox('file', 'pagemavatar[]', '', 'class="file" size="20"', 'pagemavatar_input_file'),
		'input_desc' => cot_inputbox('text', 'pagemavatardesc[]', '', 'class="desc" size="20"'),
		'input_keys' => cot_inputbox('text', 'pagemavatarkey[]', '', 'class="desc" size="20"')
	))
));
?>