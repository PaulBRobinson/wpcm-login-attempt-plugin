# WordPress + Composer + Mailgun Login Attempt Mailer

This plugin goes along with the a tutorial on Return True. Please check out the tutorial if you are unsure what this plugin does, but a brief description follows.

The plugin simply sends an email to the email address specified on the options page (Settings -> Login Attempt Mailer). The email includes the name of the blog, the username the visitor attempted to log in with and the time it occured.

It is not really meant for general use & is a demonstration in how to use Composer within a WordPress plugin. There is nothing wrong with the code though & it should be perfectly safe to use it, if you wish.

### Version
0.1

### Installation

Pretty simple. Just clone into a folder in your WordPress plugin's directory using:

```sh
git clone https://github.com/Nabesaka/wpcm-login-attempt-plugin.git login-attempt
```

Then get dependancies using

```sh
composer install
```

Active via the plugins screen then go to Settings -> Login Attempt Mailer to enable & enter your Mailgun API key, Domain & the email address the notifications should be sent to.

### License

WordPress' GPL v2

Check the license file for more details