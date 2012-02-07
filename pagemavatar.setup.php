<?php

/**
 * [BEGIN_COT_EXT]
 * Code=pagemavatar
 * Name=Page Multi Avatar
 * Description=Page Multi Avatar plugin enables you to upload, replace and delete images for a specific page bypassing PFS
 * Version=2.5.0
 * Date=18-sep-2011
 * Author=Antonio Graber, esclkm littledev.ru
 * Copyright=(c)Antonio Graber, esclkm
 * Notes=
 * Auth_guests=R
 * Lock_guests=W12345A
 * Auth_members=RW
 * Lock_members=
 * Requires_modules=page
 * [END_COT_EXT]

 * [BEGIN_COT_EXT_CONFIG]
 * items=01:select:0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16:8:Attachments per post (max.)
 * set=02:textarea::all|datas/page_mav|s_-75-75-width m_-150-150-width b_-200-200-width|0||:Format settings cat|path|thumb-x-y|reqiured|ext
 * [END_COT_EXT_CONFIG]
 */
/**
 * Pagemultiavatar for Cotonti CMF
 *
 * @version 2.00
 * @author  esclkm, graber
 * @copyright (c) 2011 esclkm, graber
 */
/* setup
 * insert into page.add template
  <!-- BEGIN: PAGEMAVATAR_ROW -->
  <div>{PAGEADD_FORM_MAVATAR} {PHP.L.Description}: {PAGEADD_FORM_MAVATARDESC_INPUT} {PHP.L.Key}: {PAGEADD_FORM_MAVATARKEY_INPUT}</div>
  <!-- END: PAGEMAVATAR_ROW -->
  {PAGEADD_FORM_MAVATAR}
 * 
 * page.edit.tpl
  <!-- BEGIN: PAGEMAVATAR_ROW -->
  <div>{PAGEEDIT_FORM_MAVATARDESC} - {PAGEEDIT_FORM_MAVATARFILE}
  <br />{PAGEEDIT_FORM_MAVATAR} {PHP.L.Description}: {PAGEEDIT_FORM_MAVATARDESC_INPUT} {PHP.L.Key}: {PAGEEDIT_FORM_MAVATARKEY_INPUT}
  <!-- IF {PAGEEDIT_FORM_MAVATARDELETE} -->
  {PHP.L.Delete} {PAGEEDIT_FORM_MAVATARDELETE}
  <!-- ENDIF -->	<hr /></div>
  <!-- END: PAGEMAVATAR_ROW -->
  {PAGEEDIT_FORM_MAVATAR}
 * 
 * page.tpl
  <!-- IF {PAGE_MAVATARCOUNT} -->
  <div class="block">	<div class="grey-line-thin" style=" margin-top:5px;"></div>
  <!-- FOR {KEY}, {VALUE} IN {PAGE_MAVATAR} -->
  <a style="padding-right:10px;" href="{VALUE.FILE}" title="{VALUE.DESC}"><img class="mavatar-catalog" src="{VALUE.S_}" /></a>
  <!-- ENDFOR -->
  </div>
  <!-- ENDIF -->
 * 
 * page.list.ptl
  <!-- IF {LIST_ROW_MAVATARCOUNT} -->
  <div class="katalogpic<!-- IF {LIST_TOP_TOTALLINES} == {LIST_ROW_NUM}--> lastel<!-- ELSE --> allel<!-- ENDIF -->">
  <!-- FOR {KEY}, {VALUE} IN {LIST_ROW_MAVATAR} -->
  <a style="display:block" href="{VALUE.FILE}" title="{VALUE.DESC}"><img class="mmavatar-catalog" src="{VALUE.FILE}" /></a>
  <!-- ENDFOR -->
  </div>
  <!-- ENDIF -->
 * 
 */
defined('COT_CODE') or die('Wrong URL');
?>