<?php
/**
 * Plugin Name: B30SC OAuth Login Configuration
 * Description: Configures OAuth login with Google and GitHub, custom login page, and Matrix theme styling
 * Version: 1.0.0
 * Author: B30SC
 * Requires at least: 6.0
 * Requires PHP: 7.4
 */

if (!defined('ABSPATH')) {
    exit;
}

class B30SC_OAuth_Login {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    private function __construct() {
        add_action('init', array($this, 'init'));
        add_action('login_enqueue_scripts', array($this, 'custom_login_styles'));
        add_filter('login_redirect', array($this, 'redirect_after_login'), 10, 3);
        add_action('login_head', array($this, 'custom_login_head'));
        
        // Redirect wp-login.php to custom login page
        add_action('login_init', array($this, 'redirect_to_custom_login'));
        
        // Add custom login page template
        add_filter('page_template', array($this, 'custom_login_page_template'));
        
        // Register custom login page on activation
        add_action('admin_init', array($this, 'create_login_page'));
    }
    
    public function init() {
        // Check if Nextend Social Login is active
        if (!class_exists('NextendSocialLogin')) {
            add_action('admin_notices', array($this, 'nextend_required_notice'));
        }
        
        // Configure OAuth providers if constants are defined
        $this->configure_oauth_providers();
    }
    
    public function nextend_required_notice() {
        ?>
        <div class="notice notice-warning">
            <p><?php _e('B30SC OAuth Login requires the Nextend Social Login plugin to be installed and activated.', 'b30sc-matrix'); ?></p>
        </div>
        <?php
    }
    
    public function configure_oauth_providers() {
        // Google OAuth Configuration
        if (defined('B30SC_GOOGLE_CLIENT_ID') && defined('B30SC_GOOGLE_CLIENT_SECRET')) {
            add_filter('nsl_google_client_id', function() {
                return B30SC_GOOGLE_CLIENT_ID;
            });
            add_filter('nsl_google_client_secret', function() {
                return B30SC_GOOGLE_CLIENT_SECRET;
            });
        }
        
        // GitHub OAuth Configuration
        if (defined('B30SC_GITHUB_CLIENT_ID') && defined('B30SC_GITHUB_CLIENT_SECRET')) {
            add_filter('nsl_github_client_id', function() {
                return B30SC_GITHUB_CLIENT_ID;
            });
            add_filter('nsl_github_client_secret', function() {
                return B30SC_GITHUB_CLIENT_SECRET;
            });
        }
    }
    
    public function custom_login_styles() {
        ?>
        <style type="text/css">
            /* Matrix Theme Login Page Styles */
            body.login {
                background-color: #000000 !important;
                color: #00FF00 !important;
                font-family: "Courier New", "Courier", monospace !important;
            }
            
            /* Matrix background effect */
            body.login::before {
                content: "";
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-image: repeating-linear-gradient(
                    0deg,
                    rgba(0, 255, 0, 0.03) 0,
                    rgba(0, 255, 0, 0.03) 1px,
                    transparent 1px,
                    transparent 2px
                );
                background-size: 100% 4px;
                pointer-events: none;
                z-index: 0;
                animation: flicker 0.15s infinite;
            }
            
            @keyframes flicker {
                0% { opacity: 0.97; }
                50% { opacity: 1; }
                100% { opacity: 0.97; }
            }
            
            #login {
                position: relative;
                z-index: 1;
            }
            
            /* Logo */
            #login h1 a,
            .login h1 a {
                background-image: none !important;
                color: #00FF00 !important;
                text-shadow: 0 0 10px #00FF00, 0 0 20px #00CC00;
                font-size: 2em;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.1em;
                width: auto;
                height: auto;
                font-family: "OCR A", "Courier New", monospace;
            }
            
            #login h1 a::before {
                content: "B30SC";
                display: block;
            }
            
            /* Login form */
            .login form {
                background-color: rgba(13, 13, 13, 0.9) !important;
                border: 2px solid #00FF00 !important;
                box-shadow: 0 0 20px rgba(0, 255, 0, 0.3) !important;
                border-radius: 4px !important;
            }
            
            .login label {
                color: #00FF00 !important;
                font-weight: bold;
                text-transform: uppercase;
                font-size: 12px;
                letter-spacing: 0.05em;
            }
            
            .login input[type="text"],
            .login input[type="password"],
            .login input[type="email"] {
                background-color: #1A1A1A !important;
                border: 1px solid #00CC00 !important;
                color: #00FF00 !important;
                font-family: "Courier New", monospace !important;
                border-radius: 2px !important;
                padding: 8px !important;
            }
            
            .login input[type="text"]:focus,
            .login input[type="password"]:focus,
            .login input[type="email"]:focus {
                border-color: #00FF00 !important;
                box-shadow: 0 0 10px rgba(0, 255, 0, 0.3) !important;
                outline: none !important;
            }
            
            /* Submit button */
            .login input[type="submit"],
            .wp-core-ui .button-primary {
                background-color: #00FF00 !important;
                border: 2px solid #00FF00 !important;
                color: #000000 !important;
                font-weight: bold !important;
                text-transform: uppercase !important;
                letter-spacing: 0.05em !important;
                text-shadow: none !important;
                box-shadow: 0 0 10px rgba(0, 255, 0, 0.3) !important;
                border-radius: 2px !important;
                font-family: "OCR A", "Courier New", monospace !important;
                transition: all 0.3s ease !important;
            }
            
            .login input[type="submit"]:hover,
            .wp-core-ui .button-primary:hover {
                background-color: #00CC00 !important;
                box-shadow: 0 0 15px #00FF00, inset 0 0 5px rgba(255, 255, 255, 0.2) !important;
                transform: scale(1.05);
            }
            
            /* Links */
            .login a {
                color: #00FF00 !important;
                text-decoration: none !important;
                transition: all 0.3s ease;
            }
            
            .login a:hover {
                color: #00CC00 !important;
                text-shadow: 0 0 5px #00FF00 !important;
            }
            
            /* Messages */
            .login .message,
            .login .success {
                border-left: 4px solid #00FF00 !important;
                background-color: rgba(0, 255, 0, 0.1) !important;
                color: #00FF00 !important;
            }
            
            .login #login_error {
                border-left: 4px solid #FF0000 !important;
                background-color: rgba(255, 0, 0, 0.1) !important;
                color: #FF6666 !important;
            }
            
            /* OAuth buttons styling */
            .nsl-container,
            .nsl-container-block {
                margin-top: 20px !important;
            }
            
            .nsl-button {
                background-color: #1A1A1A !important;
                border: 1px solid #00CC00 !important;
                color: #00FF00 !important;
                font-family: "Courier New", monospace !important;
                border-radius: 2px !important;
                transition: all 0.3s ease !important;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            
            .nsl-button:hover {
                border-color: #00FF00 !important;
                box-shadow: 0 0 10px rgba(0, 255, 0, 0.3) !important;
                transform: translateY(-2px);
            }
            
            .nsl-button-google {
                background-color: #1A1A1A !important;
            }
            
            .nsl-button-github {
                background-color: #1A1A1A !important;
            }
            
            /* Privacy link */
            .privacy-policy-page-link {
                text-align: center;
                margin-top: 16px;
            }
            
            .privacy-policy-page-link a {
                color: #00AA00 !important;
                font-size: 13px;
            }
            
            /* Checkbox */
            .login input[type="checkbox"] {
                border: 1px solid #00CC00 !important;
                background-color: #1A1A1A !important;
            }
            
            .login input[type="checkbox"]:checked::before {
                color: #00FF00 !important;
            }
            
            /* Back to blog link */
            #backtoblog a {
                color: #00AA00 !important;
            }
        </style>
        <?php
    }
    
    public function custom_login_head() {
        // Add custom JavaScript if needed
        ?>
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                // Add Matrix theme class to body
                document.body.classList.add('matrix-theme');
                
                // Customize logo link
                var logoLink = document.querySelector('#login h1 a');
                if (logoLink) {
                    logoLink.href = '<?php echo esc_url(home_url('/')); ?>';
                    logoLink.title = '<?php echo esc_attr(get_bloginfo('name')); ?>';
                }
            });
        </script>
        <?php
    }
    
    public function redirect_to_custom_login() {
        global $pagenow;
        
        // Only redirect if we're on the default login page
        // and not already on our custom login page
        if ($pagenow === 'wp-login.php' && 
            !isset($_GET['action']) && 
            !isset($_POST['wp_submit']) &&
            !isset($_GET['checkemail']) &&
            !isset($_GET['loggedout']) &&
            !is_user_logged_in()) {
            
            $custom_login_page = get_option('b30sc_custom_login_page_id');
            if ($custom_login_page) {
                $custom_login_url = get_permalink($custom_login_page);
                if ($custom_login_url) {
                    wp_safe_redirect($custom_login_url);
                    exit;
                }
            }
        }
    }
    
    public function redirect_after_login($redirect_to, $request, $user) {
        if (isset($user->roles) && is_array($user->roles)) {
            if (in_array('administrator', $user->roles)) {
                return admin_url();
            } else {
                return home_url();
            }
        }
        return $redirect_to;
    }
    
    public function create_login_page() {
        // Check if custom login page already exists
        $page_id = get_option('b30sc_custom_login_page_id');
        
        if (!$page_id || !get_post($page_id)) {
            // Create the custom login page
            $page_data = array(
                'post_title'   => 'Login',
                'post_content' => '<!-- wp:shortcode -->[b30sc_oauth_login]<!-- /wp:shortcode -->',
                'post_status'  => 'publish',
                'post_type'    => 'page',
                'post_name'    => 'login',
                'comment_status' => 'closed',
                'ping_status'  => 'closed',
            );
            
            $page_id = wp_insert_post($page_data);
            
            if ($page_id && !is_wp_error($page_id)) {
                update_option('b30sc_custom_login_page_id', $page_id);
                update_post_meta($page_id, '_wp_page_template', 'template-login.php');
            }
        }
    }
    
    public function custom_login_page_template($template) {
        if (is_page(get_option('b30sc_custom_login_page_id'))) {
            $custom_template = get_template_directory() . '/template-login.php';
            if (file_exists($custom_template)) {
                return $custom_template;
            }
        }
        return $template;
    }
}

// Initialize the plugin
B30SC_OAuth_Login::get_instance();

// Add shortcode for custom login form
add_shortcode('b30sc_oauth_login', 'b30sc_oauth_login_shortcode');
function b30sc_oauth_login_shortcode() {
    ob_start();
    
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        ?>
        <div class="b30sc-login-container logged-in">
            <h2><?php printf(__('Welcome, %s', 'b30sc-matrix'), esc_html($current_user->display_name)); ?></h2>
            <p><?php _e('You are already logged in.', 'b30sc-matrix'); ?></p>
            <p>
                <a href="<?php echo esc_url(admin_url()); ?>" class="button"><?php _e('Go to Dashboard', 'b30sc-matrix'); ?></a>
                <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="button"><?php _e('Logout', 'b30sc-matrix'); ?></a>
            </p>
        </div>
        <?php
    } else {
        ?>
        <div class="b30sc-login-container">
            <div class="login-header">
                <h1><?php _e('Access Terminal', 'b30sc-matrix'); ?></h1>
                <p class="login-subtitle"><?php _e('Authenticate to proceed', 'b30sc-matrix'); ?></p>
            </div>
            
            <div class="oauth-buttons">
                <?php
                // Display OAuth buttons if Nextend Social Login is active
                if (function_exists('nextend_social_login')) {
                    echo do_shortcode('[nextend_social_login provider="google"]');
                    echo do_shortcode('[nextend_social_login provider="github"]');
                } else {
                    ?>
                    <div class="oauth-placeholder">
                        <p><?php _e('Social login providers will appear here once configured.', 'b30sc-matrix'); ?></p>
                        <p><small><?php _e('Please install and configure Nextend Social Login plugin.', 'b30sc-matrix'); ?></small></p>
                    </div>
                    <?php
                }
                ?>
            </div>
            
            <div class="login-divider">
                <span><?php _e('or', 'b30sc-matrix'); ?></span>
            </div>
            
            <div class="traditional-login">
                <?php
                $args = array(
                    'echo'           => true,
                    'redirect'       => home_url(),
                    'form_id'        => 'loginform',
                    'label_username' => __('Username or Email', 'b30sc-matrix'),
                    'label_password' => __('Password', 'b30sc-matrix'),
                    'label_remember' => __('Remember Me', 'b30sc-matrix'),
                    'label_log_in'   => __('Log In', 'b30sc-matrix'),
                    'remember'       => true,
                    'value_remember' => false,
                );
                wp_login_form($args);
                ?>
            </div>
            
            <div class="login-footer">
                <p>
                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>"><?php _e('Lost your password?', 'b30sc-matrix'); ?></a>
                </p>
            </div>
        </div>
        <?php
    }
    
    return ob_get_clean();
}
