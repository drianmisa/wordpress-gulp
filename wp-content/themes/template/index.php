<?php get_header(); ?>

<?php
$content = get_the_content();

// Aplicamos la clase si hay contenido
if (!empty($content)) {
    echo '<div class="container pt-5 pb-5">' . $content . '</div>';
} else {
    // Manejo de caso en el que no hay contenido
    echo '<p>No hay contenido disponible.</p>';
}
?>


<?php get_footer(); ?>