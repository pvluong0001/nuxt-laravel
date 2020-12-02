FROM node:15.2.0-alpine3.10

RUN apk --no-cache add \
    g++ make python git \
    && yarn global add node-gyp \
    && rm -rf /var/cache/apk/*

ARG ENVIROMENT
ENV ENVIROMENT ${ENVIROMENT}

RUN mkdir /app
WORKDIR /app
COPY ./docker-entrypoint.sh /
RUN chmod +x /docker-entrypoint.sh

EXPOSE 8888
