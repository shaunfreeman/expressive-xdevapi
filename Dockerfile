FROM shaunfreeman/php:7.3-cli

ARG user
ARG uid

RUN useradd -u $uid $user \
    && mkdir /home/xdevapi && chown $user:$user /home/xdevapi