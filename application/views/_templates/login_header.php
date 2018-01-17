<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en-us" id="extr-page">
	<head>
		<meta charset="utf-8">
		<title> SurgiTrack</title>
		<meta name="description" content="SurgiTrack">
		<meta name="author" content="Synergy Informatics">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		
		<!-- #CSS Links -->
		<!-- Basic Styles -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/font-awesome.min.css">

		<!-- SmartAdmin Styles : Caution! DO NOT change the order -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/smartadmin-production.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/smartadmin-skins.min.css">

		<!-- SmartAdmin RTL Support -->
		<link rel="stylesheet" type="text/css" media="screen" href="<?= base_url() ?>assets/css/smartadmin-rtl.min.css"> 

		<!-- We recommend you use "your_style.css" to override SmartAdmin
		     specific styles this will also ensure you retrain your customization with each SmartAdmin update.
		<link rel="stylesheet" type="text/css" media="screen" href="css/your_style.css"> -->

		<!-- #FAVICONS -->
		<link rel="shortcut icon" href="<?= base_url() ?>assets/img/favicon/favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?= base_url() ?>assets/img/favicon/favicon.ico" type="image/x-icon">

		<!-- #GOOGLE FONT -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,300,400,700">

		<!-- #APP SCREEN / ICONS -->
		<!-- Specifying a Webpage Icon for Web Clip 
			 Ref: https://developer.apple.com/library/ios/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html -->
		<link rel="apple-touch-icon" href="i<?= base_url() ?>assets/mg/splash/sptouch-icon-iphone.png">
		<link rel="apple-touch-icon" sizes="76x76" href="<?= base_url() ?>assets/img/splash/touch-icon-ipad.png">
		<link rel="apple-touch-icon" sizes="120x120" href="<?= base_url() ?>assets/img/splash/touch-icon-iphone-retina.png">
		<link rel="apple-touch-icon" sizes="152x152" href="<?= base_url() ?>assets/img/splash/touch-icon-ipad-retina.png">
		
		<!-- iOS web-app metas : hides Safari UI Components and Changes Status Bar Appearance -->
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		
		<!-- Startup image for web apps -->
		<link rel="apple-touch-startup-image" href="<?= base_url() ?>assets/img/splash/ipad-landscape.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
		<link rel="apple-touch-startup-image" href="<?= base_url() ?>assets/img/splash/ipad-portrait.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
		<link rel="apple-touch-startup-image" href="<?= base_url() ?>assets/img/splash/iphone.png" media="screen and (max-device-width: 320px)">

	</head>
	
	<body class="animated fadeInDown">
    <script type="text/javascript" src="http://assets.freshdesk.com/widget/freshwidget.js"></script>
    <script type="text/javascript">
        FreshWidget.init("", {"queryString": "&widgetType=popup&formTitle=Help+and+Support&submitTitle=Send+feedback", "utf8": "✓", "widgetType": "popup", "buttonType": "text", "buttonText": "Support", "buttonColor": "white", "buttonBg": "#630831", "alignment": "4", "offset": "235px", "formHeight": "500px", "url": "https://surgitrack.freshdesk.com"} );
    </script>