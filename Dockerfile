FROM shaunfreeman/php:7.4-cli

ARG user
ARG uid

RUN useradd -u $uid $user \
    && mkdir /home/xdevapi && chown $user:$user /home/xdevapi