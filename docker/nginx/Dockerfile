FROM nginx:1.14.2

RUN useradd -rm -d /home/docker_user -s /bin/bash -g root -G sudo -u 1000 docker_user
USER docker_user
WORKDIR /var/www/html
