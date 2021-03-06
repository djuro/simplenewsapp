<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<!--
Design by Free CSS Templates
http://www.freecsstemplates.org
Released for free under a Creative Commons Attribution 2.5 License

Name       : Pluralism
Description: A two-column, fixed-width template fit for 1024x768 screen resolutions.
Version    : 1.0
Released   : 20071218

-->
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
    <?php use_helper('I18N') ?>
</head>
<body>
<div id="wrapper">
	<div id="wrapper2">
		<div id="header" style="position:relative;">
			<ul id="i18n-menu">
				<li><a href="/sfproject/web/en/home">EN</a></li>
				<li style="color:#fff;font-size:15px;"> | </li>
				<li><a href="/sfproject/web/hr/naslovnica">HR</a></li>
			</ul>
			<div id="logo">
				<h1><a href="<?php echo url_for('home/index')?>"><span style="font-weight:normal;">Simple</span>News</a></h1>
			</div>
			<!-- here was a menu -->
			<?php include_component('home', 'mainmenu') ?>
		</div>
		<!-- end #header -->
		<?php echo $sf_content ?>
		<!-- end #page -->
	</div>
	<!-- end #wrapper2 -->
	<div id="footer">
		<p>&copy; 2012 SimpleNews. by &#272;uro Mandini&#263; &nbsp;&nbsp;&nbsp;&nbsp;Design by <a href="http://www.nodethirtythree.com/">NodeThirtyThree</a> + <a href="http://www.freecsstemplates.org/">Free CSS Templates</a></p>
	</div>
</div>
<!-- end #wrapper -->
</body>
</html>
