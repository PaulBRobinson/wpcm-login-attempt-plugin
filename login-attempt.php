<?php
/*
Plugin Name: Login Attempt Mailer
Plugin URI: http://return-true.com
Description: This plugin will annoy you by emailing you every time there is a failed login attempt.
Author: Paul Robinson
Version: 0.1
Author URI: http://return-true.com

-------------------------------------

The code in this plugin is free to use however you wish. It is a sample for a tutorial but if you
find yourself needing to write a plugin that does this I feel sorry for you & you can use this code if you wish to.

*/

/* Composer autoload here because namespace usage must be done in Global scope */
require 'vendor/autoload.php';
use Mailgun\Mailgun;
use Mailgun\Connection\Exceptions\InvalidCredentials as InvalidCredentials;

class LoginAttemptMailer {

	var $options;

	function __construct() {
		$this->init();
		$this->options = get_option('lam_settings');
	}

	public function init() {
		add_action( 'admin_menu', array( $this, 'lam_add_admin_menu' ) );
		add_action( 'admin_init', array( $this, 'lam_settings_init' ) );
		add_action( 'wp_login_failed', array( $this, 'lam_login_failed' ) );
	}

	public function lam_login_failed($username) {

		if(!isset($this->options['lam_notify']))
			return;

		if(!isset($this->options['lam_mailgun_key']) || !isset($this->options['lam_mailgun_domain']))
			return;


		$blog = get_bloginfo( 'name' );
		$time = date('r');

		//The login failed so let's send an email
		$mg = new Mailgun($this->key);
		$mg->sendMessage($this->domain, [
			'from'		=>	'no-reply@return-true.com',
			'to'		=>	'pablorobinson@gmail.com',
			'subject'	=>	"Failed Login Attempt on '{$blog}' @ {$time}",
			'text'		=>	"Someone has tried to login to '{$blog}' at {$time} with the username '{$username}'."
		]);
	}

	public function lam_add_admin_menu() { 

		add_options_page( 'Login Attempt Mailer', 'Login Attempt Mailer', 'manage_options', 'login-attempt-mailer', array( $this, 'lam_options_page' ) );

	}

	public function lam_settings_init() { 

		register_setting( 'lam_options', 'lam_settings' );

		add_settings_section(
			'lam_options_section', 
			__( 'Be notified via email each time a visitor fails to login', 'lam_trans' ), 
			array( $this, 'lam_settings_section_render' ), 
			'lam_options'
		);

		add_settings_field( 
			'lam_notify', 
			__( 'Be notified', 'lam_trans' ), 
			array( $this, 'lam_notify_render' ), 
			'lam_options', 
			'lam_options_section' 
		);

		add_settings_field(
			'lam_mailgun_key',
			__( 'Mailgun API Key', 'lam_trans' ),
			array( $this, 'lam_mailgun_key_render' ),
			'lam_options',
			'lam_options_section'
		);

		add_settings_field(
			'lam_mailgun_domain',
			__( 'Mailgun Domain', 'lam_trans' ),
			array( $this, 'lam_mailgun_domain_render' ),
			'lam_options',
			'lam_options_section'
		);

	}

	public function lam_notify_render() { 

		?>
		<input type='checkbox' name='lam_settings[lam_notify]' <?php checked( isset($this->options['lam_notify']) ? $this->options['lam_notify'] : 0, 1 ); ?> value='1'>
		<?php

	}

	public function lam_mailgun_key_render() {

		?>
		<input type='text' name='lam_settings[lam_mailgun_key]' value='<?php echo isset($this->options['lam_mailgun_key']) ? $this->options['lam_mailgun_key'] : ''; ?>'>
		<?php

	}

	public function lam_mailgun_domain_render() {

		?>
		<input type='text' name='lam_settings[lam_mailgun_domain]' value='<?php echo isset($this->options['lam_mailgun_domain']) ? $this->options['lam_mailgun_domain'] : ''; ?>'>
		<?php

	}

	public function lam_settings_section_render() { 

		echo __( 'Check the box below to be notified when a visitor fails to login.', 'lam_trans' );

	}

	public function lam_options_page() { 

		$this->lam_check_api();

		?>
		<form action='options.php' method='post'>
			
			<h2>Login Attempt Mailer</h2>
			
			<?php
			settings_fields( 'lam_options' );
			do_settings_sections( 'lam_options' );
			submit_button();
			?>
			
		</form>
		<?php

	}

	public function lam_check_api() {
		if(isset($this->options['lam_mailgun_key']) && isset($this->options['lam_mailgun_domain'])) :
			$mg = new MailGun($this->options['lam_mailgun_key']);
			try {
				$mg->get("{$this->options['lam_mailgun_domain']}/log");
			} catch(InvalidCredentials $e) {
				?>
				<div class="error">
					<p><?php echo $e->getMessage(); ?></p>
				</div>
				<?php
			}
			
		endif;
	}

}

$lam_mailer = new LoginAttemptMailer;

?>