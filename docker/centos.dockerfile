FROM centos:7
ARG APP_PATH=/var/www/html
RUN yum update -y && yum install -y epel-release yum-utils && yum install -y http://rpms.remirepo.net/enterprise/remi-release-7.rpm && yum-config-manager --enable remi-php72
RUN yum install -y nano git php php-common php-opcache php-mcrypt php-cli php-gd php-curl php-dom php-mbstring php-simplexml php-xml php-xmlreader php-xmlwriter php-zip wget httpd httpd-devel autoremove curl
COPY /docker/apache/conf.d/site.conf /etc/httpd/conf.d/00-api.conf
COPY /docker/php/php.ini /etc/php.d/99-php.ini
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
EXPOSE 80 443 22
WORKDIR ${APP_PATH}
CMD ["/usr/sbin/httpd","-D","FOREGROUND"]
