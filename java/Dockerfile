FROM openjdk:8-jdk-alpine
COPY fasyankes.jar /fasyankes.jar
COPY config/application.properties /config/application.properties
ENTRYPOINT ["java","-Xms125m","-Xmx125m","-jar","/fasyankes.jar","--spring.config.location=/config/application.properties"]