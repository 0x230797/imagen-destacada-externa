<?php
/*
 * Plugin Name: Imagen destacada externa
 * Plugin URI: https://github.com/0x230797/imagen-destacada-externa
 * Description: Este pequeño plugin muestra una imagen externa como imagen destacada usando sólo la url de la imagen.
 * Version: 1.0
 * Author: C A N I B A L
 * Author URI: https://github.com/0x230797
 * Text Domain: imagen-destacada-externa
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 */

 if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Agregar campos personalizados al editor de entradas
function custom_featured_image_fields() {
    add_meta_box(
        'custom_featured_image_url',
        'Imagen destacada externa',
        'custom_featured_image_url_callback',
        'post',
        'side',
        'default'
    );
}

function custom_featured_image_url_callback($post) {
    // Recuperar la URL almacenada
    $image_url = get_post_meta($post->ID, '_custom_featured_image_url', true);

    // Mostrar el campo de entrada
?>
    <label for="custom_featured_image_url">URL de la imagen:</label>
    <input type="text" id="custom_featured_image_url" name="custom_featured_image_url" style="width: 100%;" value="<?php echo esc_attr($image_url); ?>">
<?php
}

add_action('add_meta_boxes', 'custom_featured_image_fields');

// Guardar la URL de la imagen como metadato al guardar la entrada
function save_custom_featured_image_url($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['custom_featured_image_url'])) {
        $image_url = esc_url($_POST['custom_featured_image_url']);
        update_post_meta($post_id, '_custom_featured_image_url', $image_url);
    }
}

add_action('save_post', 'save_custom_featured_image_url');

?>
