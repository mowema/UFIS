<?php
/* ensure that this file is called by another file */
defined('_JEXEC') or die('Restricted access');

$mainframe =& JFactory::getApplication();
$action_name = 'email_gh';
$lang =& JFactory::getLanguage();
$base_dir = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_chronoforms'.DS.'form_actions'.DS.$action_name;
$lang->load('com_chronoforms.'.$action_name, $base_dir);

$attributes = array('class' => 'mceArea');
$option_array = array(
	'theme' => 'advanced',
	'theme_advanced_toolbar_location' => 'top',
	'width' => '100%',
	'height' => '200px'
);
$options = array();
foreach ( $option_array as $k => $v ) {
	$options[] = "$k : '$v'";
}
$options = implode(",\n", $options);
// $mainframe->enqueuemessage('$options: '.print_r($options, true).'<hr/>');
$script = "
tinyMCE.init({
	mode : 'textareas',
	relative_urls: false,
	editor_selector : '{$attributes['class']}',
	$options
});
function toggleEditor(id){
	if (!tinyMCE.get(id)){
		tinyMCE.execCommand('mceAddControl', false, id);
		activateSaveButton();
	}else{
		tinyMCE.execCommand('mceRemoveControl', false, id);
		activateSaveButton();
	}
}
function toggleTemplate(id){
	if($(id).getStyle('display') != 'none'){
		$(id).setStyle('display', 'none');
	}else{
		$(id).setStyle('display', 'block');
	}
}
";
$doc =& Jfactory::getDocument();
$doc->addScriptDeclaration($script);
jimport('joomla.filesystem.file');
if ( JFile::exists(JPATH_SITE.DS.'media'.DS.'editors'.DS.'tinymce'.DS.'jscripts'.DS.'tiny_mce'.DS.'tiny_mce.js') ) {
	$doc->addScript(JURI::root().'media/editors/tinymce/jscripts/tiny_mce/tiny_mce.js');
} else {
	$doc->addScript(JURI::root().'plugins/editors/tinymce/jscripts/tiny_mce/tiny_mce.js');
}
?>
<div class="dragable" id="cfaction_email_gh">Email [GH]</div>
<!--start_element_code-->
<div class="element_code" id="cfaction_email_gh_element" >
	<label class="action_label" style="display: block; float:none!important;">Email [GH] : <?php echo $action_params['action_label']; ?></label>
	<!--<a onClick="toggleTemplate('action_email_gh_{n}_content1_cont');return false;">Edit/Hide Template</a>-->

	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_to]"
		id="action_email_gh_{n}_to"
		value="<?php echo $action_params['to']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_individual]"
		id="action_email_gh_{n}_individual"
		value="<?php echo $action_params['individual']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_check_mx]"
		id="action_email_gh_{n}_check_mx"
		value="<?php echo $action_params['check_mx']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_cc]"
		id="action_email_gh_{n}_cc"
		value="<?php echo $action_params['cc']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_bcc]"
		id="action_email_gh_{n}_bcc"
		value="<?php echo $action_params['bcc']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_subject]"
		id="action_email_gh_{n}_subject"
		value="<?php echo $action_params['subject']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_from_name]"
		id="action_email_gh_{n}_from_name"
		value="<?php echo $action_params['from_name']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_from_email]"
		id="action_email_gh_{n}_from_email"
		value="<?php echo $action_params['from_email']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_replyto_name]"
		id="action_email_gh_{n}_replyto_name"
		value="<?php echo $action_params['replyto_name']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_replyto_email]"
		id="action_email_gh_{n}_replyto_email"
		value="<?php echo $action_params['replyto_email']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_enabled]"
		id="action_email_gh_{n}_enabled"
		value="<?php echo $action_params['enabled']; ?>"
	/>
    <input
    	type="hidden"
    	name="chronoaction[{n}][action_email_gh_{n}_condition]"
    	id="action_email_gh_{n}_condition"
    	value="<?php echo $action_params['condition']; ?>"
    />
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_recordip]"
		id="action_email_gh_{n}_recordip"
		value="<?php echo $action_params['recordip']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_filter_body]"
		id="action_email_gh_{n}_filter_body"
		value="<?php echo $action_params['filter_body']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_attachments]"
		id="action_email_gh_{n}_attachments"
		value="<?php echo $action_params['attachments']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_sendas]"
		id="action_email_gh_{n}_sendas"
		value="<?php echo $action_params['sendas']; ?>"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][action_email_gh_{n}_action_label]"
		id="action_email_gh_{n}_action_label"
		value="<?php echo $action_params['action_label']; ?>"
	/>
	<textarea
	name="chronoaction[{n}][action_email_gh_{n}_content1]"
	id="action_email_gh_{n}_content1" style="display:none"><?php echo htmlspecialchars($action_params['content1']); ?></textarea>

	<input
		type="hidden"
		id="chronoaction_id_{n}"
		name="chronoaction_id[{n}]"
		value="{n}"
	/>
	<input
		type="hidden"
		name="chronoaction[{n}][type]"
		value="email_gh"
	/>
</div>
<!--end_element_code-->
<?php
$script = "
function genAutoTemplate_gh(ID){
	var Acturl = 'index.php?option=com_chronoforms&task=action_task&action_name=email&fn=generate_auto_template';
	var a = new Request.HTML({
		url: Acturl,
		method: 'get',
		onRequest: function(){
			$('action_email_gh_'+ID+'_content1_config').empty();
			$('action_email_gh_'+ID+'_content1_config').set('value', 'Working . . . please wait!');
		},
		onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript){
			if ( responseHTML != '' ) {
				$('action_email_gh_'+ID+'_content1_config').empty();
				$('action_email_gh_'+ID+'_content1_config').set('value', responseHTML);
			}
		}
	});
	a.send('form_id='+$('ChronoformId').get('value'));
}
";
$doc =& JFactory::getDocument();
$doc->addScriptDeclaration($script);
$style = "
div.tabs-panel {
	font-size: 100%;
}
div.tabs-panel tt{
	font-size: 120%;
}
div.tabs-panel span.gh_date {
	display: inline-block;
	width: 64px;
}
";
$doc->addStyleDeclaration($style);
echo "<div class='element_config' id='cfaction_{$action_name}_element_config' >";
$uri =& JFactory::getURI();
echo $PluginTabsHelper->Header(
	array(
		'general' => JText::_('CF_EM_GH_TAB_GENERAL'),
		'setup' => JText::_('CF_EM_GH_TAB_EMAIL_SETUP'),
		'template' => JText::_('CF_EM_GH_TAB_TEMPLATE'),
		'help' => JText::_('CF_EM_GH_TAB_HELP'),
		'whats_new' => JText::_('CF_EM_GH_TAB_WHATS_NEW')
	),
	$action_name.'_config_{n}'
);
echo $PluginTabsHelper->tabStart('general');
echo $HtmlHelper->input('action_'.$action_name.'_{n}_enabled_config',
	array(
		'type' => 'checkbox',
		'label' => JText::_('CF_EM_GH_LABEL_ENABLED'),
		'class' => 'checkbox',
		'value' => '1',
		'rule' => 'bool',
		'smalldesc' => JText::_('CF_EM_GH_TIP_ENABLED')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_condition_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_CONDITION'),
		'class' => 'medium_input',
		'smalldesc' => JText::_('CF_EM_GH_TIP_CONDITION')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_action_label_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_ACTION_LABEL'),
		'class' => 'medium_input',
		'smalldesc' => JText::_('CF_EM_GH_TIP_ACTION_LABEL')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_sendas_config',
	array(
		'type' => 'select',
		'label' => JText::_('CF_EM_GH_LABEL_SEND_AS'),
		'options' => array(
			'html' => 'HTML',
			'text' => 'Text',
			'both' => 'Both'
		),
		'smalldesc' => JText::_('CF_EM_GH_TIP_SEND_AS')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_individual_config',
	array(
		'type' => 'checkbox',
		'label' => JText::_('CF_EM_GH_LABEL_INDIVIDUAL'),
		'class' => 'checkbox',
		'value' => '0',
		'rule' => 'bool',
		'smalldesc' => JText::_('CF_EM_GH_TIP_INDIVIDUAL')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_check_mx_config',
	array(
		'type' => 'checkbox',
		'label' => JText::_('CF_EM_GH_LABEL_CHECK_MX'),
		'class' => 'checkbox',
		'value' => '1',
		'rule' => 'bool',
		'smalldesc' => JText::_('CF_EM_GH_TIP_CHECK_MX')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_attachments_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_ATTACHMENTS'),
		'class' => 'big_input',
		'value' => '',
		'smalldesc' => JText::sprintf('CF_EM_GH_TIP_ATTACHMENTS', JPATH_SITE)
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_recordip_config',
	array(
		'type' => 'checkbox',
		'label' => JText::_('CF_EM_GH_LABEL_RECORD_IP'),
		'class' => 'checkbox',
		'value' => '1',
		'rule' => 'bool',
		'smalldesc' => JText::_('CF_EM_GH_TIP_RECORD_IP')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_filter_body_config',
	array(
		'type' => 'checkbox',
		'label' => JText::_('CF_EM_GH_LABEL_FILTER_BODY'),
		'class' => 'checkbox',
		'value' => '1',
		'rule' => 'bool',
		'smalldesc' => JText::_('CF_EM_GH_TIP_FILTER_BODY')
	)
);
echo $PluginTabsHelper->tabEnd();
echo $PluginTabsHelper->tabStart('setup');
echo $HtmlHelper->input('action_'.$action_name.'_{n}_to_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_TO'),
		'class' => 'medium_input',
		'smalldesc' => JText::_('CF_EM_GH_TIP_TO')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_subject_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_SUBJECT'),
		'class' => 'medium_input',
		'smalldesc' => JText::sprintf('CF_EM_GH_TIP_SUBJECT', $uri->getHost() )
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_from_name_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_FROM_NAME'),
		'class' => 'medium_input',
		'smalldesc' => JText::sprintf('CF_EM_GH_TIP_FROM_NAME', $uri->getHost() )
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_from_email_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_FROM_EMAIL'),
		'class' => 'medium_input',
		'smalldesc' => JText::sprintf('CF_EM_GH_TIP_FROM_EMAIL', $uri->getHost())
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_cc_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_CC'),
		'class' => 'medium_input',
		'smalldesc' => JText::_('CF_EM_GH_TIP_CC')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_bcc_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_BCC'),
		'class' => 'medium_input',
		'smalldesc' => JText::_('CF_EM_GH_TIP_BCC')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_replyto_name_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_REPLY_TO_NAME'),
		'class' => 'medium_input',
		'smalldesc' => JText::_('CF_EM_GH_TIP_REPLY_TO_NAME')
	)
);
echo $HtmlHelper->input('action_'.$action_name.'_{n}_replyto_email_config',
	array(
		'type' => 'text',
		'label' => JText::_('CF_EM_GH_LABEL_REPLY_TO_EMAIL'),
		'class' => 'medium_input',
		'smalldesc' => JText::_('CF_EM_GH_TIP_REPLY_TO_EMAIL')
	)
);
echo $PluginTabsHelper->tabEnd();
echo $PluginTabsHelper->tabStart('template');
?>
<div>
	<input
		type="button"
		name="action_email_gh_refresh_button"
		id="action_email_gh_refresh_button"

	value="Generate Auto Template" onClick="genAutoTemplate_gh('{n}')"
/>
</div>
	<a class="editor_toggler_link" onclick="toggleEditor('action_email_gh_{n}_content1_config');return false;">Add/Remove editor</a>
<?php
echo $HtmlHelper->input('action_'.$action_name.'_{n}_content1_config',
	array(
		'type' => 'textarea',
		'label' => JText::_('CF_EM_GH_LABEL_CONTENT1'),
		'class' => 'text_editor',
		'label_over' => true,
		'rows' => 20,
		'cols' => 70,
		'smalldesc' => JText::_('CF_EM_GH_TIP_CONTENT1')
	)
);
echo $PluginTabsHelper->tabEnd();
echo $PluginTabsHelper->tabStart('help');
jimport('joomla.filesystem.file');
$tag =& $lang->getTag();
if ( !JFile::exists ( $base_dir.DS.'language'.DS.$tag.DS.$action_name.'_help.php' ) ) {
	$tag =& $lang->getDefault();
	if ( !JFile::exists ( $base_dir.DS.'language'.DS.$tag.DS.$action_name.'_help.php' ) ) {
		$tag = 'en-GB';
	}
}
include( $base_dir.DS.'language'.DS.$tag.DS.$action_name.'_help.php' );
echo $PluginTabsHelper->tabEnd();
echo $PluginTabsHelper->tabStart('whats_new');
$tag =& $lang->getTag();
if ( !JFile::exists ( $base_dir.DS.'language'.DS.$tag.DS.$action_name.'_whats_new.php' ) ) {
	$tag =& $lang->getDefault();
	if ( !JFile::exists ( $base_dir.DS.'language'.DS.$tag.DS.$action_name.'_whats_new.php' ) ) {
		$tag = 'en-GB';
	}
}
include( $base_dir.DS.'language'.DS.$tag.DS.$action_name.'_whats_new.php' );
echo $PluginTabsHelper->tabEnd();
?>
</div>