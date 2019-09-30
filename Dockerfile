FROM shaunfreeman/php:cli-latest

ARG user
ARG uid

RUN useradd -u $uid $user \
    && mkdir /home/xdevapi && chown $user:$user /home/xdevapi