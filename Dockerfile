FROM romeoz/docker-phpfpm:5.5
MAINTAINER romeOz <serggalka@gmail.com>

ENV VERSION_PECL_COUCHBASE="2.1.0"

WORKDIR /tmp/

RUN	\
	buildDeps='libcouchbase2-libevent libcouchbase-dev php5-dev' \
    && apt-get update \
    && apt-get install -y wget \
    && apt-get update \
    && wget -O/etc/apt/sources.list.d/couchbase.list http://packages.couchbase.com/ubuntu/couchbase-ubuntu1204.list \
    && wget -O- http://packages.couchbase.com/ubuntu/couchbase.key | sudo apt-key add - \
	&& apt-get update \
	&& apt-get install -y $buildDeps \
	&& apt-get install -y php5-redis php5-memcache php5-memcached php5-apcu \
	&& wget http://pecl.php.net/get/couchbase-${VERSION_PECL_COUCHBASE}.tgz \
	&& tar zxvf couchbase-${VERSION_PECL_COUCHBASE}.tgz \
	&& cd "couchbase-${VERSION_PECL_COUCHBASE}" \
	&& phpize && ./configure && make install && echo "Installed ext/couchbase-${VERSION_PECL_COUCHBASE}" \
	&& echo "extension = couchbase.so" >> /etc/php5/fpm/conf.d/couchbase.ini \
	&& echo "extension = couchbase.so" >> /etc/php5/cli/conf.d/couchbase.ini \
	&& echo "apc.enable_cli=1" >> /etc/php5/mods-available/apcu.ini \
	# Install composer
	&& curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
	# Cleaning
	&& apt-get purge -y --auto-remove php5-dev wget \
	&& apt-get autoremove -y && apt-get clean \
	&& rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

EXPOSE 9000

CMD ["/usr/sbin/php5-fpm"]