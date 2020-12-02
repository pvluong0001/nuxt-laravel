FROM nginx:1.17.2

RUN rm -rf /etc/nginx/conf.d/default.conf
COPY api.conf /etc/nginx/conf.d/api.conf
COPY client.conf /etc/nginx/conf.d/client.conf

WORKDIR /app
