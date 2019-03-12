FROM centos:7

# Install & Add repo
RUN rpm -Uvh https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
RUN rpm -Uvh http://rpms.famillecollet.com/enterprise/remi-release-7.rpm

# Install PHP7.1 & Apache
RUN yum --enablerepo=remi-php71 install php php-devel php-gd php-xml php-mbstring php-opcache php-mcrypt php-mysqlnd -y

# Install zip & unzip
RUN yum install -y zip unzip git

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install node.js
RUN curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.29.0/install.sh | bash
ENV NODE_VERSION 6.11.3
RUN . ~/.nvm/nvm.sh && nvm install $NODE_VERSION && nvm alias default $NODE_VERSION && npm install -g gulp

# Clear yum cache
RUN yum clean all

# for web
EXPOSE 80

CMD /usr/sbin/httpd -DFOREGROUND
