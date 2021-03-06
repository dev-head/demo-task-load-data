Demo Task :: Load Data
======================

Just a demo app that is used to load data.  

----

Installation 
------------

### Development Dependencies

- [Virtual Box](https://www.virtualbox.org/wiki/Downloads)
- [Vagrant](https://www.vagrantup.com/downloads.html)

### Development VM Configuration
There are two configuration files, the default and local. Local should not be checked in should be used to override any of the project default configurations or add new ones. 

#### Create New Config to modify
```
cp config/vagrant.local.json.example config/vagrant.local.json
```

----

### VM Access

#### Start / SSH / Stop / Destroy / Provision the VM

```
vagrant up
vagrant ssh
vagrant halt
vagrant destroy
vagrant provision
```

----

### Install PHP Dependencies

#### Get latest composer version
```
./composer self-update
```

#### Install latest dependencies
```
./composer update
```

----

Use
---

#### Run task manually
```
php bin/console load -c config/load-indeed.json
```

Testing
-------

- [Peridot](http://peridot-php.github.io/)

```
./vendor/bin/peridot
```




