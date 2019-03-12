FROM centos:latest

# Install & Add repo
RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm

# Install PHP7.1 & Apache
RUN yum --enablerepo=remi-php71 install php php-devel php-gd php-xml php-mbstring php-opcache php-mcrypt php-mysqlnd -y

# Install zip & unzip
RUN yum install zip unzip -y

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear yum cache
RUN yum clean all

# for web
EXPOSE 80

CMD /usr/sbin/httpd -DFOREGROUND
