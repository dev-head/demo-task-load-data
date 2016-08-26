#!/bin/bash

rpm -Uvh https://mirror.webtatic.com/yum/el7/epel-release.rpm
rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
yum install -y git htop iftop mlocate wget screen lsof nmap strace dstat telnet nano vim-enhanced

PHP_VERSION_INSTALLED=$(rpm -qa | grep php | awk -F "-" '{print $1}' | uniq)
PHP_VERSION="php70w"
echo "[$PHP_VERSION]::[$PHP_VERSION_INSTALLED]"

# basic switcher for php versions, too lazy to hard code it out each time but not lazy enough to make this better.
if [[ "$PHP_VERSION" != "$PHP_VERSION_INSTALLED" ]]; then
    echo "[PHP]::[REMOVING]::[$PHP_VERSION_INSTALLED]"
    yum remove -y $PHP_VERSION_INSTALLED $PHP_VERSION_INSTALLED-devel $PHP_VERSION_INSTALLED-common \
    $PHP_VERSION_INSTALLED-fpm $PHP_VERSION_INSTALLED-cli $PHP_VERSION_INSTALLED-opcache $PHP_VERSION_INSTALLED-pecl-xdebug \
    $PHP_VERSION_INSTALLED-mbstring $PHP_VERSION_INSTALLED-bcmath $PHP_VERSION_INSTALLED-xml $PHP_VERSION_INSTALLED-pdo \
    $PHP_VERSION_INSTALLED-mysqlnd $PHP_VERSION_INSTALLED-process $PHP_VERSION_INSTALLED-gd $PHP_VERSION_INSTALLED-soap

    echo "[PHP]::[INSTALLING]::[$PHP_VERSION]"
    yum install -y $PHP_VERSION $PHP_VERSION-devel $PHP_VERSION-common \
    $PHP_VERSION-fpm $PHP_VERSION-cli $PHP_VERSION-opcache $PHP_VERSION-pecl-xdebug \
    $PHP_VERSION-mbstring $PHP_VERSION-bcmath $PHP_VERSION-xml $PHP_VERSION-pdo $PHP_VERSION-mysqlnd \
    $PHP_VERSION-process $PHP_VERSION-gd $PHP_VERSION-soap
fi


