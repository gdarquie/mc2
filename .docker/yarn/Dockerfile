FROM node:9.11.2-alpine

RUN apk add --no-cache yarn

WORKDIR /app
COPY entrypoint.sh /docker/entrypoint.sh

ENTRYPOINT ["/bin/sh", "/docker/entrypoint.sh"]
