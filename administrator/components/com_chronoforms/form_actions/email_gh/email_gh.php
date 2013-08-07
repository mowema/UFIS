<?php
/**
 * CHRONOFORMS version 4.0
 * Copyright (c) 2011 Bob Janes. GreyHead.net All rights reserved.
 * Author: Greyhead
 *
 * @license: GNU/GPL
 *
 * */

/* ensure that this file is called by another file */
defined( '_JEXEC' ) or die( 'Restricted access' );

if ( class_exists( 'CfactionEmailGH' ) ) {
	return;
}
class CfactionEmailGH {
	var $action     = null;
	var $base_dir   = null;
	var $check_mx   = null;
	var $data       = null;
	var $events     = null;
	var $form       = null;
	var $group      = null;
	var $log        = null;
	var $logging    = null;
	var $params     = null;

	function CfactionEmailGH() {
		$this->action = 'email_gh';
		$this->base_dir = JPATH_SITE.DS.'administrator'.DS.'components'.DS.'com_chronoforms'.DS.'form_actions'.DS.$this->action;
		$lang =& JFactory::getLanguage();
		$lang->load( 'com_chronoforms.'.$this->action, $this->base_dir );
		$this->details  = array(
			'title' => 'Email [GH]',
			'tooltip' => JText::_( 'CF_EM_GH_TITLE' )
		);
		$this->group = array(
			'id' => 'gh',
			'title' => JText::_( 'CF_EM_GH_GROUP' )
		);
		$this->params = array(
			'to' => '',
			'cc' => '',
			'bcc' => '',
			'subject' => '',
			'from_name' => '',
			'from_email' => '',
			'replyto_name' => '',
			'replyto_email' => '',
			'enabled' => true,
			'condition' => '',
			'action_label' => '',
			'individual' => false,
			'check_mx' => true,
			'recordip' => true,
			'attachments' => '',
			'sendas' => 'html',
			'filter_body' => true,
			'content1' => JText::_( 'CF_EM_GH_DEFAULT_TEMPLATE' )
		);
	}

	function load( $clear ) {
		if ( $clear ) {
			$action_params = $this->params;
		}
		return array(
			'action_params' => $action_params
		);
	}

	function run( $form, $actiondata ) {
		// $mainframe =& JFactory::getApplication();
		$params = new JParameter( $actiondata->params );
		// Check the conditional test for the email
		$condition = trim( $params->get( 'condition', "" ) );
		if ( $condition ) {
			$condition = explode( '::', $condition );
			if ( count( $condition ) == 2 ) {
				$input = trim( $condition[0] );
				$value = trim( $condition[1] );
				if ( substr( $input, 0, 1 ) == '{' && substr( $input, -1, 1 ) == '}' ) {
					$input = substr( $input, 1, strlen( $input ) - 2 );
					$input = trim( $input );
				}
				if ( !$input || !$value || $form->data[$input] != $value ) {
					$form->debug['Email info'][] = "Conditional Email cancelled: {$input} was {$form->data[$input]} not {$value}";
					return false;
				}
			}
		}
		// get the remaining parameters
		$skip_array = array(
			'content1'
		);
		foreach ( $this->params as $k => $v ) {
			if ( in_array( $k, $skip_array ) ) {
				continue;
			}
			$$k = trim( $params->get( $k, $v ) );
			// Allow over-ride from form data for registered users
			// if ( in_array($k, array('enabled', 'individual', 'recordip', 'sendas')) ) {
			//  if ( isset( $form->data[$k] ) && $form->data[$k] ) {
			//   $$k = $form->data[$k];
			//  }
			// }
		}
		// :: TODO :: over-rides need to link to action id to make sure they only affect this action
		// allow form-data over-ride of email body
		// if ( isset($form->data['email_body']) && $form->data['email_body'] ) {
		//  $email_body = $form->data['email_body'];
		// } else {
		//  $email_body = $actiondata->content1;
		// }
		$email_body = $actiondata->content1;
		$uri =& JFactory::getURI();
		$send     = true;
		$this->check_mx =& $check_mx;

		//add the IP address to the form data
		$form->data['IPADDRESS'] = JRequest::getString( 'REMOTE_ADDR', '', 'server' );
		$this->form =& $form;
		$this->data =& $form->data;
		// add the IP tag to the email body if not already set.
		if ( $recordip && strpos( $email_body, '{IPADDRESS}' ) === false ) {
			$email_body   .= JText::_( 'CF_EM_GH_DEFAULT_IP' );
		}
		ob_start();
		eval( "?>" . $email_body );
		$email_body = ob_get_clean();
		//build email template from defined fields and posted fields
		$email_body = $this->curlyReplacer( $email_body );
		$filter = new JFilterInput( null, null, 1, 1 );
		$temp = '';
		if ( $sendas == 'text' || $sendas == 'both' ) {
			$temp = $filter->clean( $email_body, 'STRING' );
		}
		if ( $sendas == 'html' || $sendas == 'both' ) {
			if ( $temp ) {
				$temp = "<!--{$temp}-->\n\n\n";
			}
			if ( $filter_body ) {
				$email_body = $filter->clean( $email_body, 'HTML' );
			}
			$temp .= "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">
			<html>
				<head>
					<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">
					<base href=\"" . JURI::base() . "/\" />
					<title>Email</title>
				</head>
				<body>$email_body</body>
			</html>";
		}
		$email_body = $temp;
		unset( $temp );

		// From Name
		$from_name = $this->curlyReplacer( $from_name );
		if ( !$from_name ) {
			$from_name = "Admin at {$uri->getHost()}";
		}
		// From Email address
		$count = str_replace( '##OK##', '', $from_email );
		if ( !empty( $count ) ) {
			$from_email = $this->curlyReplacer( $count );
		}
		$from_email = filter_var( $from_email, FILTER_SANITIZE_EMAIL );
		if ( !filter_var( $from_email, FILTER_VALIDATE_EMAIL ) ) {
			$from_email = 'info@' . $uri->getHost();
		}
		// Subject
		$subject = $this->curlyReplacer( $subject );
		if ( !$subject ) {
			$subject = JText::_( 'CF_EM_GH_TEXT_SUBJECT', $uri->getHost() );
		}
		// Recipients
		$recipients = $this->getEmailParam( $to );
		if ( !$recipients ) {
			$form->debug['Email errors'][] = JText::_( 'CF_EM_GH_DEBUG_NO_TO_EMAIL' );
			$send        = false;
		}
		// CCs
		$cc_emails = $this->getEmailParam( $cc );
		if ( !$cc_emails ) {
			$cc_emails = array( );
		}
		// BCCs
		$bcc_emails = $this->getEmailParam( $bcc );
		if ( !$bcc_emails ) {
			$bcc_emails = array( );
		}

		// ReplyTo Email
		$replyto_email = $this->getEmailParam( $replyto_email );
		// ReplyTo Names
		if ( $replyto_email !== false && $replyto_name ) {
			$replyto_name = $this->curlyReplacer( $replyto_name );
			$replyto_name = explode( ',', $replyto_name );
			foreach ( $replyto_email as $k => $v ) {
				if ( !isset( $replyto_name[$k] ) || !$replyto_name[$k] ) {
					$replyto_name[$k] = trim($v);
				}
			}
		} else {
			$replyto_name = '';
		}
		$email_attachments = array( );
		if ( $attachments ) {
			$attachments = explode( ',', $attachments );
			foreach ( $attachments as $v ) {
				if ( !$v ) {
					continue;
				}
				if ( $v == '{file_array}' && count($this->data['file_array']) > 0 ) {
					// handle the special 'file_array' value
					foreach ( $this->data['file_array'] as $f ) {
						if ( file_exists($f) ) {
							$email_attachments[] = $f;
						}
					}
				} else if ( substr( $v, 0, 1 ) == '{' && substr( $v, -1, 1 ) == '}' && strpos('{', $v, 1) === false) {
					// handle uploaded files
					$v = substr( $v, 1, strlen( $v ) - 2 );
					$v = trim( $v );
					if ( isset( $form->files[$v] ) ) {
						$email_attachments[] = $form->files[$v]['path'];
					}
				} else {
					// handle indivdual files
					$v = str_replace( '{#path#}', JPATH_SITE, $v );
					$v = $this->curlyReplacer( $v );
					$v = str_replace( array(
							"/",
							"\\"
						), DS, $v );
					$v = str_replace( DS . DS, DS, $v );
					jimport( 'joomla.filesystem.file' );
					if ( JFile::exists( $v ) ) {
						$email_attachments[] = $v;
					}
				}
			}
		}
		if ( $send ) {
			$jversion = new JVersion();
			// $mail =& JFactory::getMailer();
			if ( $individual && count( $recipients ) > 1 ) {
				// send individual emails
				foreach ( $recipients as $to ) {
					if ( $jversion->RELEASE > 1.5 ) {
						$mail =& JFactory::getMailer();
						$email_sent = $mail->sendMail( $from_email, $from_name, $to, $subject, $email_body, $sendas, $cc_emails, $bcc_emails, $email_attachments, $replyto_email, $replyto_name );
					} else {
						if ( !count( $replyto_name ) ) {
							$replyto_name = '';
						}
						$email_sent = JUtility::sendMail( $from_email, $from_name, $to, $subject, $email_body, $sendas, $cc_emails, $bcc_emails, $email_attachments, $replyto_email, $replyto_name );
					}
					if ( $email_sent === true ) {
						$form->debug['Email info'][$to] = JText::_( 'CF_EM_GH_DEBUG_EMAIL_SENT' );
					} else {
						$form->debug['Email info'][$to] = JText::sprintf( 'CF_EM_GH_DEBUG_EMAIL_FAIL', $email_sent->toString() );
					}
					unset( $mail );
				}
			} else {
				if ( $jversion->RELEASE > 1.5 ) {
					$mail =& JFactory::getMailer();
					$email_sent = $mail->sendMail( $from_email, $from_name, $recipients, $subject, $email_body, $sendas, $cc_emails, $bcc_emails, $email_attachments, $replyto_email, $replyto_name );
				} else {
					if ( !count( $replyto_name ) ) {
						$replyto_name = '';
					}
					$email_sent = JUtility::sendMail( $from_email, $from_name, $recipients, $subject, $email_body, $sendas, $cc_emails, $bcc_emails, $email_attachments, $replyto_email, $replyto_name );
				}
				if ( $email_sent === true ) {
					$form->debug['Email info'][] = JText::_( 'CF_EM_GH_DEBUG_EMAIL_SENT' );
				} else {
					$form->debug['Email info'][] = JText::sprintf( 'CF_EM_GH_DEBUG_EMAIL_FAIL', $email_sent->toString() );
				}
			}
		} else {
			$form->debug['Email info'][] = JText::_( 'CF_EM_GH_DEBUG_EMAIL_STOP' );
		}
		$form->debug['Email info'][] = JText::sprintf( 'CF_EM_GH_DEBUG_FROM', $from_name, $from_email );
		if ( $replyto_email || $replyto_name ) {
			$form->debug['Email info'][] = JText::sprintf( 'CF_EM_GH_DEBUG_REPLY_TO', implode( ', ', $replyto_name ), implode( ', ', $replyto_email ) );
		}
		$form->debug['Email info'][] = JText::sprintf( 'CF_EM_GH_DEBUG_TO', implode( ', ', $recipients ) );
		if ( $cc_emails ) {
			$form->debug['Email info'][] = JText::sprintf( 'CF_EM_GH_DEBUG_CC', implode( ', ', $cc_emails ) );
		}
		if ( $bcc_emails ) {
			$form->debug['Email info'][] = JText::sprintf( 'CF_EM_GH_DEBUG_BCC', implode( ', ', $bcc_emails ) );
		}
		$form->debug['Email info'][] = JText::sprintf( 'CF_EM_GH_DEBUG_SUBJECT', $subject );
		$form->debug['Email body'][] = $email_body;
		if ( count( $email_attachments ) ) {
			$form->debug['Email attachments'][] = JText::sprintf( 'CF_EM_GH_DEBUG_FILES', implode( "\n", $email_attachments ) );
		}
	}
	/**
	 * Parse an email list inserting values from the form data
	 *
	 * @param string  $value a comma separated list of static or dynamic email addresses
	 * @param [type]  $data  [description]
	 * @return [type]
	 */
	function getEmailParam( $value ) {
		$mainframe =& JFactory::getApplication();
		if ( !$value ) {
			return false;
		}
		$data =& $this->data;
		// explode a comma separated string
		$value_array = explode( ',', $value );
		$return = array( );
		// loop through the entries
		foreach ( $value_array as $v ) {
			$v = trim( $v );
			// skip if $v is an empty string
			if ( !$v ) {
				continue;
			}
			if ( substr( $v, 0, 1 ) == '{' && substr( $v, -1, 1 ) == '}' ) {
				// This is a curly-bracket placeholder
				$v = substr( $v, 1, strlen( $v ) - 2 );
				$v = trim( $v );
				// add the '.'' exploder to handle Model IDs
				$temp = explode( '.', $v );
				$d = $data;
				foreach ( $temp as $t ) {
					$t = trim( $t );
					if ( $t ) {
						$d = $d[$t];
					}
				}
				if ( isset( $d ) ) {
					if ( !is_array( $d ) && strpos( $d, ',' ) ) {
						$d = explode( ',', $d );
					}
					if ( is_array( $d ) ) {
						foreach ( $d as $vv ) {
							$vv = trim( $vv );
							$vv = $this->checkEmail( $vv );
							if ( $vv ) {
								$return[] = $vv;
							}
						}
					} else {
						$v = $this->checkEmail( $d );
						if ( $v ) {
							$return[] = $v;
						}
					}
				}
			} else {
				$return[] = $v;
			}
		}
		return $return;
	}
	/**
	 * check that the email address is valid
	 *
	 * @param string  $v candidate email address
	 * @return string/false
	 */
	function checkEmail( $v ) {
		$v = trim( $v );
		$v = filter_var( $v, FILTER_SANITIZE_EMAIL );
		if ( !filter_var( $v, FILTER_VALIDATE_EMAIL ) ) {
			return false;
		}
		if ( !$this->domainExists( $v ) ) {
			return false;
		}
		return $v;
	}
	/**
	 * call the curly-replacer
	 *
	 * @param string  $v candidate email address
	 * @return string/false
	 */
	function curlyReplacer( $v ) {
		return $this->form->curly_replacer( $v, $this->data );
	}
	/**
	 * Updated version of David Walsh's email domain checker
	 * http://davidwalsh.name/php-email-validator-mx-dns-record-check
	 *
	 * @return boolean
	 * @author
	 * */

	function domainExists( $email, $record = 'MX' ) {
		if ( $this->check_mx ) {
			$domain = explode( '@', $email );
			return checkdnsrr( $domain[1], $record );
		} else {
			return true;
		}
	}
}
?>
