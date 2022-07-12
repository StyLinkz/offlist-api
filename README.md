# Setup development environment

1. Download and install VirtualBox.
1. Download and install Vagrant from https://www.vagrantup.com/downloads.
1. Now you can go to the root folder and run `vagrant up`.
    The first run will setup the VM. This can take a while. After that,
    you can visit http://localhost:8085 to visit the page.
1. The database ist available at `localhost:3365`, with user `root` and password `secret`.

## Presentation

For presentation we use grok, https://ngrok.com/. With that tool you can redirect traffic from a subdomain to your local network.

To work properly, you have to set the **APP_ENV** var in the file .env from `local` to `production`. That achieves that the links switch from http to https. Local http will not work anymore. That prevents the **mixed block** or **mixed content** error.

To effect the changes, go into the VM with `vagrant ssh` and run the following.

```
cd /vagrant
php artisan config:cache
php artisan config:clear
php artisan cache:clear
```