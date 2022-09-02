# Prueba Tecnica Destinia.

### Inicio del proyecto:
1. Ejecutar los siguiente comandos
    ```bash
    composer install
    ```
2. Configurar el archivo ```/src/Config/Database``` para los parámetros de conexión a Mysql
3. Ejecutar el siguiente comando para la creación de tablas y llenado de data inicial
    ```bash
    php index.php config install
    ```
---
### Base de datos.
El archivo ```/bd/destiniadb.sql``` contiene la estructura propuesta para la prueba

---
### Ejecución del proyecto
Ejecutar en la consola de comandos la siguiente instrucción:
```bash
php index.php search default name=azul
```
El resultado esperado es el siguiente:
```bash
Hotel Azul,3,Habitación doble con vistas,Valencia,Valencia
Apartametos Azul,10,4,Valencia,Valencia
```
---
### Ejecución de test  
La ejecución de los test se realiza mediante el siguiente comando
```bash
./vendor/bin/phpunit 
```