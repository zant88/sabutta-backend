FROM openjdk:8-jdk-alpine
COPY proxy.jar /proxy.jar
COPY config/application.properties /config/application.properties
ENTRYPOINT ["java","-Xms125m","-Xmx125m","-jar","/proxy.jar","--spring.config.location=/config/application.properties"]