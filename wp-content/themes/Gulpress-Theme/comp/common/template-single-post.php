<?php get_header(); ?>
<?php include(get_template_directory() . '/comp/common/header/header.php'); ?>
<div id="comp-page-title-banner" style="background-image: url('<?php echo site_url();?>/wp-content/themes/cherrypop/assets/common/dummy21.png')">
	<?php include(get_template_directory() . '/comp/common/main-menu/main-menu.php'); ?>
    <div class="comp-wrap">
        <h2>
            Fiscalía General de Justicia del Estado de México
        </h2>
    </div>
</div>      
    <div class="template-single-custom-post">
        <div class="template-content">
            <?php
                if (have_posts()) {
                    while (have_posts()) {
                        the_post_thumbnail();
                        the_post();       
                        the_title('<h1>', '</h1>');
                        the_content();
                    }
                } else {
                    echo 'Lo sentimos, no se encontraron publicaciones.';
                }
            ?>
        </div>
    </div>
<?php get_footer(); ?>
