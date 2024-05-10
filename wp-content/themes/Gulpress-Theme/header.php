<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?><?php wp_title(); ?></title>

    <?php    wp_head(); ?>
</head>
<header>
    <?php include(get_template_directory() . '/comp/common/header/header.php'); ?>
</header>
<body <?php body_class(); ?>>
