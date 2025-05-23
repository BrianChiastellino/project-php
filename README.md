# Guía Rápida para Levantar el Proyecto

## Requisitos Previos
- **PHP ≥ 8.0**  
- **Symfony CLI**  
- **Composer**  
- **MySQL** (puede ser local con XAMPP, MAMP, Laragon, etc.)


## Configurar la Conexión a MySQL
1. Abre `.env` o crea `.env.local`  
2. Localiza la línea `DATABASE_URL`  
3. Ajusta usuario, contraseña y nombre de base de datos:
   ```dotenv
   DATABASE_URL="mysql://TU_USUARIO:TU_CONTRASEÑA@127.0.0.1:3306/tu_base_de_datos?serverVersion=8.0&charset=utf8mb4"

## Pasos a seguir para configurar base de datos. (MYSQL)
1. composer install
2. php bin/console doctrine:database:create
3. php bin/console make:entity
4. php bin/console make:migration
5. php bin/console doctrine:migrations:migrate

## Probar el proyecto e interactuar con la consola

```doteenv --> Genera una campaña
  php bin/console app:create-campaign- 
```
```doteenv --> Listado de camapañas
php bin/console app:list-campaigns
```
```doteenv --> Crear influencer
php bin/console app:create-influencer
```
```doteenv --> Listar influencers
php bin/console app:list-influencers
```
```doteenv ---> Asignar influencers a campañas
php bin/console app:asignar-influencer
```




 


