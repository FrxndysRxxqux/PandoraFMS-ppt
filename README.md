# WebApp - Prueba técnica PANDORA-FMS.
## Descripcion
Esta aplicación web utiliza la libreria [AltoRouter] para gestionar las rutas.
El proyecto está dividido en dos ejercicios, cada uno en su respectiva carpeta.
> Requisitos
- PHP + Apache
- Compose
- Mysql
- Recomendado: XAMPP para entorno local.
___
## Instalación y configuración.
### 1. Clonar el repositorio
Clona el proyecto directamente en el `rootDirectory` de apache.
> "C:/xampp/htdocs/" ~> si usas xampp
``` bash
git clone https://github.com/FrxndysRxxqux/PandoraFMS-ppt.git
```
### 2. Configuración de apache
El sitio está configurado para funcionar con apache mediante un archivo .htaccess que gestiona las URLs amigales (rewrite rules).
 
### 3. Composer install
Para ejecutar el ejercicio 2 es necesario instalar dependencias de Composer.
En la carpeta `/PandoraFMS-ppt/ejercicio2-sistema-citas-online` y ejecuta
```bash
$ composer install
```
Este comando instalará `AltoRouter` automaticamente.
 
### 4. Configuración de base de datos.
Importar la base de datos desde el archivo `dbClicTerapia.sql`
El archivo `dbController.php` contiene los datos de conexion a la base de datos.
Para cargar la base de datos es necesario importar la base de datos, que está adjunta tambien en el repositorio como `dbCitasApp.sql`
Modifica las credenciales según tu entorno local:
```php
private $host = 'localhost';
private $user = 'nombre de usuario para tu base de datos';
private $pass = 'contraseña para tu base de datos';
private $dbname = 'nombre de tu base de datos';
```
### Estructura del proyecto
```
📁 htdocs(apache RootDirectory)/
├── 📁 PandoraFMS-ppt
│    📁 ejercicio1-decodificacion/
│    ├── 📄 ej1-decodificacion.php
│    ├── 📄 file-user-info-hacked.csv
│    └── 📄 file-user-info-unhacked.csv
│   
│    📁 ejercicio2-sistema-citas-online/
│    ├── 📁 app/
│    │   ├── 📁 Controllers/
│    │   │   └── 📄 DbController.php
│    │   └── 📁 Resources/
│    │       └── 📁 Views/
│    │           └── 📄 View.php
│    ├── 📄 composer.json
│    ├── 📄 composer.lock
│    ├── 📄 dbClicTerapia.slq
│    └── 📄 index.php
📄 .gitignore 
📄 .htaccess.
🟥📄 Prueba técnica desarrollo - Pandora FMS 2025.pdf
```