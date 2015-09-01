<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<title>VISIR LabClient</title>
	<script language="javascript">
	<!--
		AC_FL_RunContent = 0;
		DetectFlashVer = 0;
		requiredMajorVersion = 9;
		requiredMinorVersion = 0;
		requiredRevision = 115;
	-->
	</script>
	<script src="flash/AC_RunActiveContent.js" language="javascript"></script>
</head>


<body>
<!-- Start -->
<?php

	//check if isset
	$backToISB = (isset($_GET['backToISB'])) ? true : false;
	$select = (isset($_GET['select'])) ? true : false;
	$teacher = (isset($_GET['teacher'])) ? 1 : 0;

	//load setups
	$setupsJsonStr = file_get_contents('./setups.json', FILE_USE_INCLUDE_PATH);
	$setupsJson = json_decode($setupsJsonStr);
	$setupId = $_GET['setup'];
	if( isset( $setupsJson->{$setupId}->setup ) ) {
		$setup = urlencode($setupsJson->{$setupId}->setup);
	} else {
		$setupId = 'default';
		$setup = urlencode($setupsJson->{'default'}->setup);
	}

?>

	<?php if($backToISB): ?>
	<a href="http://ilabs.cti.ac.at/" id="backToISB">&lt;&lt; back to iLab Service Broker</a>
	<br><br>
	<?php endif; ?>


	<div id="outerwrapper">
		<div id="innerwrapper">
			<div id="pageintro">
				<table class="simpleform" border="0">
					<tr>
						<td class="style2">
						<?php if($couponVerified): ?>
						<script language="JavaScript" type="text/javascript">
						<!--
						if (AC_FL_RunContent == 0 || DetectFlashVer == 0) {
							console.log('This page requires AC_RunActiveContent.js.');
						} else {
							var hasRightVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
							if (hasRightVersion) { //if we've detected an acceptable version
								// embed the flash movie
								AC_FL_RunContent(
									'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0',
									'flashVars', 'cookie=<?php echo $cred['issuerGuid'].':'.$cred['couponId'].':'.$cred['passkey'];if($setup!==null){echo '&savedata='.$setup;}echo '&teacher='.$teacher;?>',
									'width', '970',
									'height', '498',
									'src', 'spectrumloader',
									'quality', 'high',
									'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
									'align', 'middle',
									'play', 'true',
									'loop', 'true',
									'scale', 'showall',
									'wmode', 'window',
									'devicefont', 'false',
									'id', 'spectrumloader',
									'bgcolor', '#FFFAFA',
									'name', 'spectrumloader',
									'menu', 'true',
									'allowScriptAccess', 'sameDomain',
									'allowFullScreen', 'false',
									'movie', 'flash/loader',
									'salign', ''
								); //end AC code
							} else { //flash is too old or we can't detect the plugin
								var alternateContent = 'Alternate HTML content should be placed here.'
										+ 'This content requires the Adobe Flash Player.'
										+ '<a href=http://www.macromedia.com/go/getflash/>Get Flash</a>';
								document.write(alternateContent); //insert non-flash content
							}
						}
						// -->
						</script>

						<noscript>
						// Provide alternate content for browsers that do not support scripting
						// or for those that have scripting disabled.
						Alternate HTML content should be placed here. This content requires the Adobe Flash Player.
						<a href="http://www.macromedia.com/go/getflash/">Get Flash</a>
						</noscript>

						<?php else: ?>
						<p>Unable to verify coupon!</p>
						<?php endif; ?>
						</td>
					</tr>
					<?php if($select): ?>
					<tr>
						<td class="style2">
							<br>
							<h2>Other Setups:</h2>
							<ul>
							<?php
								$selectBaseURL = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['PHP_SELF'] . '?coupon_id=' . $cred['couponId'] . '&passkey=' . $cred['passkey'];
								$selectBaseURL .= ($select) ? '&select' : '';
								$selectBaseURL .= ($teacher===1) ? '&teacher' : '';
								$selectBaseURL .= ($backToISB) ? '&backToISB' : '';
								$selectBaseURL .= '&setup=';

								foreach ($setupsJson as $key) {
									if( $setupsJson->{$setupId}->title === $key->title ) {
										echo '<li>'.$key->title.'</li>';
									} else {
										echo '<li><a href="'.$selectBaseURL.$key->id.'">'.$key->title.'</a></li>';
									}
								}
							?>
							</ul>
						</td>
					</tr>
					<?php endif; ?>
				</table>
				<br/>
			</div><!-- end pageintro div -->
		</div><!-- end innerwrapper div -->
	</div>
	<br clear="all">


<!-- End -->
</body>
</html>
