# Importing the latest registry's image avaible
FROM registry:2.8.1
# Editing the config file to fix some bugs when pushing back "non-garbage-collected" layers / images
RUN sed -i -r 's|inmemory|""|g'  /etc/docker/registry/config.yml
RUN apk add --no-cache bash
RUN apk add --no-cache curl
RUN apk add --no-cache jq

ENV REGISTRY="http://127.0.0.1" \
    PORT="5000" 

COPY scripts /usr/bin

