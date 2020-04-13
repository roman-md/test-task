<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Page\Asset;
global $APPLICATION;
?>


<!DOCTYPE html>
<html lang="<?= LANGUAGE_ID?>">
	<head>

		<?
        $APPLICATION->ShowHead();

        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/bootstrap-4.4.1/css/bootstrap.min.css');
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/bootstrap-4.4.1/css/bootstrap-grid.min.css');
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/bootstrap-4.4.1/css/bootstrap-reboot.min.css');
        Asset::getInstance()->addCss(SITE_TEMPLATE_PATH . '/assets/css/styles.css');

        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/jquery-3.5.0/js/jquery-3.5.0.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/bootstrap-4.4.1/js/bootstrap.min.js');
        Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . '/assets/js/scripts.js');
        ?>

        <title><?$APPLICATION->ShowTitle();?></title>
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" /> 	
	</head>
    <?$APPLICATION->ShowPanel();?>
	<body>
        <div class="container">

	
						