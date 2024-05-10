<?php
define( 'template', 1.0 );

/*-----------------------------------------------------------------------------------*/
/* FLUSH PERMALINKS
/* Activate only when needed
/*-----------------------------------------------------------------------------------*/
//flush_rewrite_rules( false );
/*-----------------------------------------------------------------------------------*/
/* REMOVE COMMENTS SECTION ON ADMIN
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_init', 'my_remove_admin_menus' );
function my_remove_admin_menus() {
	remove_menu_page( 'edit-comments.php' );
}


/***************************************************************************** */
/*************LOGOTIPO************* */
/*******************************************************************************/
// Función para agregar la sección y control del logo al Personalizador
function logo_sitio_setup() {
	add_theme_support('custom-logo');
}
add_action('after_setup_theme', 'logo_sitio_setup');


// SOPORTE PARA TITULO
add_theme_support('title-tag');




/*-----------------------------------------------------------------------------------*/
/* 	LIMPIEZA EN WP_HEAD()
/*-----------------------------------------------------------------------------------*/
remove_action('wp_head', 'rsd_link'); //Links for Flickr
remove_action('wp_head', 'wlwmanifest_link'); //Prints windows live writer xml
remove_action('wp_head', 'wp_generator');  //Prints WP Version
remove_action('wp_head', 'start_post_rel_link'); //Prints related links
remove_action('wp_head', 'index_rel_link'); //Prints related links
remove_action('wp_head', 'adjacent_posts_rel_link'); //Prints related links
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);    //removes short links

// REMOVER WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
//DESABILITAR RSS
function itsme_disable_feed() {
    wp_die( __( 'No feed available, please visit the <a href="'. esc_url( home_url( '/' ) ) .'">homepage</a>!' ) );
}
add_action('do_feed', 'itsme_disable_feed', 1);
add_action('do_feed_rdf', 'itsme_disable_feed', 1);
add_action('do_feed_rss', 'itsme_disable_feed', 1);
add_action('do_feed_rss2', 'itsme_disable_feed', 1);
add_action('do_feed_atom', 'itsme_disable_feed', 1);
add_action('do_feed_rss2_comments', 'itsme_disable_feed', 1);
add_action('do_feed_atom_comments', 'itsme_disable_feed', 1);
remove_action( 'wp_head', 'feed_links_extra', 3 );
remove_action( 'wp_head', 'feed_links', 2 );

// DESABILITAR EL BLOQUE DE GUTTEMBERG
add_action( 'wp_print_styles', 'wps_deregister_styles', 100 );
function wps_deregister_styles() {
    wp_dequeue_style( 'wp-block-library' );
}
// REMOVER WP HEAD REST API
remove_action('template_redirect', 'rest_output_link_header', 11, 0);
remove_action('wp_head', 'rest_output_link_wp_head', 10);
remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
remove_action('wp_head', 'rel_canonical');
//Remove JQuery migrate
function remove_jquery_migrate( $scripts ) {
    if ( ! is_admin() && isset( $scripts->registered['jquery'] ) ) {
        $script = $scripts->registered['jquery'];
        if ( $script->deps ) {
// Check whether the script has any dependencies
            $script->deps = array_diff( $script->deps, array( 'jquery-migrate' ) );
        }
    }
}
add_action( 'wp_default_scripts', 'remove_jquery_migrate' );
/*-----------------------------------------------------------------------------------*/
/* Add post thumbnail/featured image support
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'post-thumbnails' );
/*-----------------------------------------------------------------------------------*/
/*	REGISTRAR MAINMENU
/*-----------------------------------------------------------------------------------*/
register_nav_menus(
    array(
        'primary'	=>	__( 'Primary Menu', 'template' ), 
    )
);

/*-----------------------------------------------------------------------------------*/
/* STYLOS Y SCRIPTS
/*-----------------------------------------------------------------------------------*/
// remove wp version param from any enqueued scripts
function vc_remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'vc_remove_wp_ver_css_js', 9999 );
add_filter( 'script_loader_src', 'vc_remove_wp_ver_css_js', 9999 );


function template_scripts()  {
    // Enqueue the theme stylesheet
    wp_enqueue_style('style', get_stylesheet_uri());

    // Enqueue custom CSS file
    wp_enqueue_style('template-css', get_template_directory_uri() . '/src/css/template.css');

    // Enqueue Bootstrap CSS file
    wp_enqueue_style('bootstrap-css', get_stylesheet_directory_uri() . '/src/bootstrap-5.3.3-dist/css/bootstrap.min.css');

    // Enqueue Bootstrap JavaScript file
    wp_enqueue_script('bootstrap-js', get_stylesheet_directory_uri() . '/src/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js', array('jquery'), null, true);

    // Enqueue custom JavaScript file
    wp_enqueue_script('app-js', get_stylesheet_directory_uri() . '/src/min-js/app.min.js', array(), null, true);
}
add_action( 'wp_enqueue_scripts', 'template_scripts' );




class FLHM_HTML_Compression
{
	protected $flhm_compress_css = true;
	protected $flhm_compress_js = true;
	protected $flhm_info_comment = true;
	protected $flhm_remove_comments = true;
	protected $html;
	public function __construct($html)
	{
		if (!empty($html))
		{
			$this->flhm_parseHTML($html);
		}
	}
	public function __toString()
	{
		return $this->html;
	}
	protected function flhm_bottomComment($raw, $compressed)
	{
		$raw = strlen($raw);
		$compressed = strlen($compressed);
		$savings = ($raw-$compressed) / $raw * 100;
		$savings = round($savings, 2);
		return '<!--HTML compressed, size saved '.$savings.'%. From '.$raw.' bytes, now '.$compressed.' bytes-->';
	}
	protected function flhm_minifyHTML($html)
	{
		$pattern = '/<(?<script>script).*?<\/script\s*>|<(?<style>style).*?<\/style\s*>|<!(?<comment>--).*?-->|<(?<tag>[\/\w.:-]*)(?:".*?"|\'.*?\'|[^\'">]+)*>|(?<text>((<[^!\/\w.:-])?[^<]*)+)|/si';
		preg_match_all($pattern, $html, $matches, PREG_SET_ORDER);
		$overriding = false;
		$raw_tag = false;
		$html = '';
		foreach ($matches as $token)
		{
			$tag = (isset($token['tag'])) ? strtolower($token['tag']) : null;
			$content = $token[0];
			if (is_null($tag))
			{
				if ( !empty($token['script']) )
				{
					$strip = $this->flhm_compress_js;
				}
				else if ( !empty($token['style']) )
				{
					$strip = $this->flhm_compress_css;
				}
				else if ($content == '<!--wp-html-compression no compression-->')
				{
					$overriding = !$overriding;
					continue;
				}
				else if ($this->flhm_remove_comments)
				{
					if (!$overriding && $raw_tag != 'textarea')
					{
						$content = preg_replace('/<!--(?!\s*(?:\[if [^\]]+]|<!|>))(?:(?!-->).)*-->/s', '', $content);
					}
				}
			}
			else
			{
				if ($tag == 'pre' || $tag == 'textarea')
				{
					$raw_tag = $tag;
				}
				else if ($tag == '/pre' || $tag == '/textarea')
				{
					$raw_tag = false;
				}
				else
				{
					if ($raw_tag || $overriding)
					{
						$strip = false;
					}
					else
					{
						$strip = true;
						$content = preg_replace('/(\s+)(\w++(?<!\baction|\balt|\bcontent|\bsrc)="")/', '$1', $content);
						$content = str_replace(' />', '/>', $content);
					}
				}
			}
			if ($strip)
			{
				$content = $this->flhm_removeWhiteSpace($content);
			}
			$html .= $content;
		}
		return $html;
	}
	public function flhm_parseHTML($html)
	{
		$this->html = $this->flhm_minifyHTML($html);
		if ($this->flhm_info_comment)
		{
			$this->html .= "\n" . $this->flhm_bottomComment($html, $this->html);
		}
	}
	protected function flhm_removeWhiteSpace($str)
	{
		$str = str_replace("\t", ' ', $str);
		$str = str_replace("\n",  '', $str);
		$str = str_replace("\r",  '', $str);
		while (stristr($str, '  '))
		{
			$str = str_replace('  ', ' ', $str);
		}
		return $str;
	}
}
function flhm_wp_html_compression_finish($html)
{
	return new FLHM_HTML_Compression($html);
}
function flhm_wp_html_compression_start()
{
	ob_start('flhm_wp_html_compression_finish');
}



