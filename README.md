# Infrastructure Homework Assignment


## Exercise Description
You will provision a simple reverse-proxied LAMP infrastructure using the configuration management software [Ansible](http://www.ansible.com/home) and a [Vagrant](http://www.vagrantup.com/) file to launch it. Your Vagrantfile should utilize the [Puppletlabs CentOS 6.5 Vagrant box](http://puppet-vagrant-boxes.puppetlabs.com/centos-65-x64-virtualbox-nocm.box).

### Server Infrastructure
The infrastructure should consist of two server systems, each running the latest versions of available packages and services:

1. `front` - nginx, memcached
2. `app` - apache2, php5.3, mysql-server

### Provisioning & Configuration Process
The process should perform the following steps:

1. Setup `nginx` and `memcached` on the `front` server
2. Setup `apache2`, `php5.3`, `mysql-server` on the `app` server
3. Download and install the following PHP script into the document root of
Apache on `app`:
[test.php](https://github.com/WarbyParker/homework/blob/master/infrastructure/test.php)
_There may be other packages required on the servers to successfully execute the
test.php script._
4. Download and run the following SQL script on `app`.  After correctly loading,
it should have loaded the `infratest` database with a test table:
[test.sql](https://github.com/WarbyParker/homework/blob/master/infrastructure/test.sql)
5. Create and grant all privileges to user `infratest` on the MySQL database
`infratest` with the password `infra1234`.
6. Add entries to the `/etc/hosts` file on both servers to map the hosts `front`
and `app` to their respective IP addresses
7. Create firewall rules so that the reverse proxy server only accepts
connections on port 80 from anywhere, while the app server only accepts
connections on port 8080 from the proxy server.
8. Configure nginx on the reverse proxy server to proxy HTTP requests on port 80
to the app server's Apache instance on port 8080.
9. Configure nginx on the reverse proxy server to add the HTTP header
`X-Forwarded-For` with the value of the IP address of the client making the
request.

## Submission Requirements

You will provide the Ansible Playbook and Vagrantfile to setup and
configure each server.  Running 'vagrant up' will provision each server
to these requirements.  Accessing nginx on `front` or Apache on `app` should
respond with the same results.  There should be no errors on the resulting
`test.php` page.