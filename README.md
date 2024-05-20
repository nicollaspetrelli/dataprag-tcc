## Projeto

## Requisitos

 - Docker engine ou docker desktop
 - IDE de preferência (caso for **wsl2** com conexão ao docker)

## Instruções para Instalações Locais


Copiar `.env.example` -> `.env` e altere as configurações se necessário 

Rodar comando:

    docker-compose build

Dentro do container php fpm:

    composer install
    
    chmod 777 -R storage
    
    php artisan key:generate
    
    php artisan storage:link
   
   Após rodar os comandos levante os containers

    docker-compose up -d
Feito isso a aplicação ira retornar 3 containers:

 - Webserver: Nginx
 - Database: MySQL
 - PHP-fpm: 7.4
 
 Acesse **localhost:80** ou a porta definida no `docker-compose.yml` e seja feliz =)

## Usar o banco local

- php artisan migrate
- php artisan db:seed
- php artisan dataprag:clients

## xDebug

VSCODE config for running remote xDebug:

```json
{
    "name": "DataPrag Xdebug",
    "type": "php",
    "request": "launch",
    "port": 9003,
    "pathMappings": {
        "/var/www": "${workspaceRoot}" 
    },
},
```

## Contribuições
Agradecemos às seguintes pessoas que contribuíram para este projeto:

<table>
  <tr>
    <td align="center">
      <a href="#">
        <img src="https://avatars.githubusercontent.com/u/52557321?v=4" width="100px;" alt="Foto do Nicollas Petrelli no GitHub"/><br>
        <sub>
          <b>Nicollas Petrelli</b>
        </sub>
      </a>
    </td>
  </tr>
</table>

> Escrito por [Nicollas Petrelli](https://github.com/nicollasPetrelli).