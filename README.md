# WordPress + Composer + Mailgun Login Attempt Mailer

This plugin is an example plugin that goes along with a tutorial on Return True. Please check out the [tutorial](http://return-true.com/creating-a-wordpress-plugin-with-composer-and-the-mailgun-api/) for more information. A brief description of what this plugin does is located below.

The plugin simply sends an email to the email address specified on the options page (Settings -> Login Attempt Mailer), when a login failure is detected. The email includes the name of the blog, the username the visitor attempted to use, and the time the attempt occured.

It is not really meant for general use & is a demonstration of how to use Composer within a WordPress plugin. There is nothing wrong with the code though & it should be perfectly safe to use, if you wish.

### Version
0.1

### Installation

Pretty simple. Just clone into a folder in your WordPress plugin's directory using:

```sh
git clone https://github.com/Nabesaka/wpcm-login-attempt-plugin.git login-attempt
```

Then get dependancies using

```sh
cd login-attempt
composer install
```

Activate via the plugins screen then go to Settings -> Login Attempt Mailer to enable & enter your Mailgun API key, Domain & the email address the notifications should be sent to.

### License

WordPress' GPL v2

Check the license file for more details