FROM openjdk:19-jdk-alpine3.16

RUN addgroup -S nonroot \
    && adduser -S nonroot -G nonroot

USER nonroot

RUN apk add --no-cache bc
RUN apk add --update coreutils && rm -rf /var/cache/apk/*

WORKDIR /home/capacity/

ADD ./docker/script.sh /bin/script.sh
RUN chmod +x /bin/script.sh

ENTRYPOINT ["sh", "/bin/script.sh"]
