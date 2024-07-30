nohup java -Xms125m -Xmx125m -jar /root/fasyankes/proxy/proxy.jar --spring.config.location=/root/fasyankes/proxy/config/application.properties > /root/fasyankes/proxy/log.txt &
tail -f /root/fasyankes/proxy/log.txt
