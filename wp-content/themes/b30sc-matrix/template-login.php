<?php
/**
 * Template Name: Login Page
 * Description: Custom login page template with Matrix theme styling
 */

// Redirect if already logged in
if (is_user_logged_in() && !isset($_GET['action'])) {
    wp_safe_redirect(admin_url());
    exit;
}

get_header();
?>

<style>
.b30sc-login-container {
    max-width: 500px;
    margin: 60px auto;
    padding: 40px;
    background-color: rgba(13, 13, 13, 0.9);
    border: 2px solid #00FF00;
    border-radius: 4px;
    box-shadow: 0 0 20px rgba(0, 255, 0, 0.3);
}

.b30sc-login-container.logged-in {
    text-align: center;
}

.login-header {
    text-align: center;
    margin-bottom: 30px;
}

.login-header h1 {
    color: #00FF00;
    font-size: 2.5rem;
    text-shadow: 0 0 10px #00FF00, 0 0 20px #00CC00;
    margin-bottom: 10px;
    font-family: "OCR A", "Courier New", monospace;
}

.login-subtitle {
    color: #00CC00;
    font-size: 1rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
}

.oauth-buttons {
    margin: 30px 0;
}

.oauth-buttons .nsl-container {
    margin-bottom: 15px;
}

.oauth-buttons .nsl-button {
    width: 100%;
    background-color: #1A1A1A !important;
    border: 1px solid #00CC00 !important;
    color: #00FF00 !important;
    font-family: "Courier New", monospace !important;
    padding: 15px !important;
    border-radius: 2px !important;
    transition: all 0.3s ease !important;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    font-weight: bold;
}

.oauth-buttons .nsl-button:hover {
    border-color: #00FF00 !important;
    box-shadow: 0 0 10px rgba(0, 255, 0, 0.3) !important;
    transform: translateY(-2px);
}

.oauth-placeholder {
    background-color: #1A1A1A;
    border: 1px solid #00CC00;
    padding: 20px;
    border-radius: 2px;
    text-align: center;
}

.oauth-placeholder p {
    color: #00CC00;
    margin: 10px 0;
}

.login-divider {
    text-align: center;
    margin: 30px 0;
    position: relative;
}

.login-divider::before,
.login-divider::after {
    content: "";
    position: absolute;
    top: 50%;
    width: 40%;
    height: 1px;
    background-color: #00CC00;
}

.login-divider::before {
    left: 0;
}

.login-divider::after {
    right: 0;
}

.login-divider span {
    background-color: rgba(13, 13, 13, 0.9);
    padding: 0 15px;
    color: #00CC00;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.1em;
}

.traditional-login {
    margin: 30px 0;
}

.traditional-login form {
    display: flex;
    flex-direction: column;
}

.traditional-login label {
    color: #00FF00;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.05em;
    margin-bottom: 8px;
    margin-top: 15px;
}

.traditional-login input[type="text"],
.traditional-login input[type="password"],
.traditional-login input[type="email"] {
    background-color: #1A1A1A;
    border: 1px solid #00CC00;
    color: #00FF00;
    font-family: "Courier New", monospace;
    padding: 12px;
    border-radius: 2px;
    transition: all 0.3s ease;
}

.traditional-login input[type="text"]:focus,
.traditional-login input[type="password"]:focus,
.traditional-login input[type="email"]:focus {
    outline: none;
    border-color: #00FF00;
    box-shadow: 0 0 10px rgba(0, 255, 0, 0.3);
}

.traditional-login input[type="submit"] {
    background-color: #00FF00;
    border: 2px solid #00FF00;
    color: #000000;
    padding: 12px 20px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: "OCR A", "Courier New", monospace;
    border-radius: 2px;
    margin-top: 20px;
}

.traditional-login input[type="submit"]:hover {
    background-color: #00CC00;
    box-shadow: 0 0 10px #00FF00, inset 0 0 5px rgba(255, 255, 255, 0.2);
    transform: scale(1.02);
}

.traditional-login .login-remember {
    display: flex;
    align-items: center;
    margin-top: 15px;
}

.traditional-login .login-remember label {
    margin: 0 0 0 8px;
    font-size: 0.85rem;
}

.traditional-login input[type="checkbox"] {
    width: 18px;
    height: 18px;
    border: 1px solid #00CC00;
    background-color: #1A1A1A;
}

.login-footer {
    text-align: center;
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid #00CC00;
}

.login-footer a {
    color: #00CC00;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.login-footer a:hover {
    color: #00FF00;
    text-shadow: 0 0 5px #00FF00;
}

.b30sc-login-container.logged-in h2 {
    color: #00FF00;
    text-shadow: 0 0 10px #00FF00;
    margin-bottom: 20px;
}

.b30sc-login-container.logged-in p {
    color: #CCCCCC;
    margin: 15px 0;
}

.b30sc-login-container.logged-in .button {
    display: inline-block;
    background-color: #00FF00;
    color: #000000;
    border: 2px solid #00FF00;
    padding: 10px 20px;
    font-weight: bold;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    text-decoration: none;
    transition: all 0.3s ease;
    font-family: "OCR A", "Courier New", monospace;
    border-radius: 2px;
    margin: 5px;
}

.b30sc-login-container.logged-in .button:hover {
    background-color: #00CC00;
    box-shadow: 0 0 10px #00FF00;
    transform: scale(1.05);
}

@media (max-width: 768px) {
    .b30sc-login-container {
        margin: 30px 20px;
        padding: 30px 20px;
    }
    
    .login-header h1 {
        font-size: 2rem;
    }
}
</style>

<main class="wp-site-blocks">
    <div class="wp-block-group" style="padding: 40px 20px; min-height: 100vh;">
        <?php
        while (have_posts()) :
            the_post();
            the_content();
        endwhile;
        ?>
    </div>
</main>

<?php
get_footer();
?>
