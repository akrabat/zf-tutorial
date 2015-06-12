# -*- mode: ruby -*-
# vi: set ft=ruby :

VAGRANTFILE_API_VERSION = '2'

@script = <<SCRIPT

newphp 7

# makephp 7


echo '
server {
    listen       80;
    server_name  localhost;
    root         /vagrant/public;
    index        index.php index.html index.htm;
    access_log   /var/log/nginx/default-access.log  main;
    error_log    /var/log/nginx/default-error.log;

    location / {
        try_files $uri $uri/ @rewrite;
    }
    location @rewrite {
        index index.php;
        rewrite ^(.*)$ /index.php;
    }

    location ~ \.php {
        include                  fastcgi_params;
        fastcgi_keep_conn        on;
        fastcgi_index            index.php;
        fastcgi_split_path_info  ^(.+\.php)(/.+)$;
        fastcgi_param            PATH_INFO $fastcgi_path_info;
        fastcgi_param            SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param            APPLICATION_ENV 'php7dev';
        fastcgi_intercept_errors on;
        fastcgi_pass             unix:/var/run/php-fpm.sock;

    }
}

' > /etc/nginx/conf.d/default.conf

service nginx restart

cd /vagrant
curl -Ss https://getcomposer.org/installer | php
php composer.phar install --no-progress

# database
DB=zftutorial
mysql -uvagrant -pvagrant -e "DROP DATABASE IF EXISTS $DB";
mysql -uvagrant -pvagrant -e "CREATE DATABASE $DB";
mysql -u vagrant -pvagrant $DB < /vagrant/data/data.sql

echo "** Visit http://localhost:8888 in your browser for to view the application **"
SCRIPT

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|
  config.vm.box = 'rasmus/php7dev'
  config.vm.network "forwarded_port", guest: 80, host: 8888
  config.vm.hostname = "zf1-tutorial.local"
  # config.vm.synced_folder '.', '/vagrant'
  # config.vm.synced_folder '.', '/var/www/default'
  
  config.vm.provision 'shell', inline: @script

  config.vm.provider "virtualbox" do |vb|
    vb.customize ["modifyvm", :id, "--memory", "1024"]
  end

end