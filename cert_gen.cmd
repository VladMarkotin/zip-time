@echo OFF
rem УКАЖИТЕ ПРАВИЛЬНЫЕ РАСПОЛОЖЕНИЯ ФАЙЛОВ
set OPENSSL_CONF=D:\OpenServer\OSPanel\modules\http\Apache_2.4-PHP_7.2-7.4\conf\openssl.cnf
PATH=%PATH%;D:\OpenServer\OSPanel\modules\http\Apache_2.4-PHP_7.2-7.4\bin

rem Количество дней действия сертификата
set days=730
set key_bits=2048

rem Наименование домена, для которого создаётся сертификат
set dname=zip-time.local

rem УКАЖИТЕ ПРАВИЛЬНЫЕ РАСПОЛОЖЕНИЯ ФАЙЛОВ
rem Расположение корневого сертификата и ключа
set root_cert=D:\OpenServer\OSPanel\userdata\config\cert_files\rootCA.crt
set root_key=D:\OpenServer\OSPanel\userdata\config\cert_files\rootCA.key

echo [trust_cert] > %dname%.cnf
echo subjectAltName=@alt_names >> %dname%.cnf
echo keyUsage=digitalSignature,keyEncipherment,dataEncipherment >> %dname%.cnf
echo extendedKeyUsage=serverAuth,clientAuth >> %dname%.cnf
echo [alt_names] >> %dname%.cnf
echo DNS.1 = %dname% >> %dname%.cnf

openssl genrsa -out %dname%.key %key_bits%

openssl req -sha256 -new -utf8 -key %dname%.key -out %dname%.csr -subj /emailAddress="info\@ospanel\.io"/C=RU/stateOrProvinceName="Russian Federation"/L=Moscow/O="Open Server Panel"/OU=Software/CN=%dname%:3000

rem Для создания сертификата, подписанного доверенным сертификатом
openssl x509 -sha256 -req -days %days% -in %dname%.csr -extfile %dname%.cnf -extensions trust_cert -CA %root_cert% -CAkey %root_key% -out %dname%.crt

openssl x509 -in %dname%.crt -noout -purpose

rem Удаление временных файлов
del %dname%.csr
del %dname%.cnf

pause