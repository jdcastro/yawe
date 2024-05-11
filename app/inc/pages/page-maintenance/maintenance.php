<?php

class Custom_Options_Plugin {

    private $option_group;
    private $option_name;
    private $menu_slug;

    public function __construct() {
        $this->option_group = 'myoption-group';
        $this->option_name = 'myoption-name';
        $this->menu_slug = YAWE_PLUGIN_SLUG;

        add_action('admin_menu', array($this, 'add_plugin_page'));
        add_action('admin_init', array($this, 'page_init'));
    }

    public function add_plugin_page() {
        add_submenu_page(
            YAWE_PLUGIN_SLUG,
            'maintance',
            'maintance',
            'manage_options',
            'yawe_maintenance',
            array($this, 'create_admin_page')
        );
    }

    public function create_admin_page() {
        ?>
        <div class="wrap">
            <h2>Custom Options</h2>
            <form method="post" action="options.php">
                <?php
                settings_fields($this->option_group);
                do_settings_sections($this->menu_slug);
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function page_init() {
        register_setting(
            $this->option_group,   // Opción de grupo
            $this->option_name,    // Nombre de la opción
            array($this, 'sanitize') // Callback de sanitización
        );

        add_settings_section(
            'setting_section_id',           // ID de la sección
            'Custom Options',               // Título de la sección
            array($this, 'print_section_info'), // Callback de la sección
            $this->menu_slug               // Página a la que pertenece la sección
        );

        add_settings_field(
            'quiero',                       // ID del campo
            'Quiero',                       // Etiqueta del campo
            array($this, 'quiero_callback'), // Callback del campo
            $this->menu_slug,               // Página a la que pertenece el campo
            'setting_section_id'            // Sección a la que pertenece el campo
        );

        add_settings_field(
            'nombre',                       // ID del campo
            'Nombre',                       // Etiqueta del campo
            array($this, 'nombre_callback'), // Callback del campo
            $this->menu_slug,               // Página a la que pertenece el campo
            'setting_section_id'            // Sección a la que pertenece el campo
        );
    }

    public function sanitize($input) {
        $sanitized_input = array();
        if (isset($input['quiero'])) {
            $sanitized_input['quiero'] = sanitize_text_field($input['quiero']);
        }
        if (isset($input['nombre'])) {
            $sanitized_input['nombre'] = sanitize_text_field($input['nombre']);
        }
        return $sanitized_input;
    }

    public function print_section_info() {
        print 'Enter your custom options below:';
    }

    public function quiero_callback() {
        $options = get_option($this->option_name);
        $checked = isset($options['quiero']) ? checked(1, $options['quiero'], false) : '';
        echo '<input type="checkbox" id="quiero" name="' . $this->option_name . '[quiero]" value="1" ' . $checked . '/>';
    }

    public function nombre_callback() {
        $options = get_option($this->option_name);
        $value = isset($options['nombre']) ? esc_attr($options['nombre']) : '';
        echo '<input type="text" id="nombre" name="' . $this->option_name . '[nombre]" value="' . $value . '"/>';
    }
}

if (is_admin()) {
   // $custom_options_plugin = new Custom_Options_Plugin();
}

