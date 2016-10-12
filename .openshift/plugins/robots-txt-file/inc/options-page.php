<?php

class CD_RDTE_Admin_Page
{
    private static $ins = null;

    protected $setting = 'cd_rdte_content';

    public static function instance()
    {
        if (null === self::$ins) {
            self::$ins = new self();
        }

        return self::$ins;
    }

    public static function init()
    {
        add_action('admin_init', array(self::instance(), 'settings'));
    }
    
    public function settings()
    {
        register_setting(
            'reading', 
            $this->setting,
            array($this, 'cleanSetting')
        );

        add_settings_section(
            'robots-txt',
            __('Robots.txt File', 'wp-robots-txt'),
            '__return_false',
            'reading'
        );

        add_settings_field(
            'cd_rdte_robots_content',
            __('Robots.txt', 'wp-robots-txt'),
            array($this, 'field'),
            'reading',
            'robots-txt',
            array('label_for' => $this->setting)
        );
    }
    public function field()
    {
        $content = get_option($this->setting);
        if (!$content) {
            $content = $this->getDefaultRobots();
        }

        printf(
            '<textarea name="%1$s" id="%1$s" rows="10" class="large-text">%2$s</textarea>',
            esc_attr($this->setting),
            esc_textarea($content)
        );

        echo '<p class="description">';
        _e('Edit your robots.txt file and click the "Save Changes" button bellow. Have any question? <a href="http://usefulblogging.com/wordpress-robots-txt-file/">Ask here.</a>', 'wp-robots-txt');
        echo '</p>';
    }
    public function cleanSetting($in)
    {
        if(empty($in)) {
            // TODO: why does this kill the default settings message?
            add_settings_error(
                $this->setting,
                'cd-rdte-restored',
                __('Robots.txt restored to default.', 'wp-robots-txt'),
                'updated'
            );
        }

        return esc_html(strip_tags($in));
    }
    
    protected function getDefaultRobots()
    {
        $public = get_option('blog_public');

        $output = "User-agent: *\n";
        if ('0' == $public) {
            $output .= "Disallow: /\n";
        } else {
            $path = parse_url(site_url(), PHP_URL_PATH);
            $output .= "Disallow: $path/wp-admin/\n";
            $output .= "Allow: $path/wp-admin/admin-ajax.php\n";
        }

        return $output;
    }
}
