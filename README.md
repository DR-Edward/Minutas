<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Minutas Manager Dev Demo: **[http://dev-minutas.dredward.site](http://dev-minutas.dredward.site)**

## Notas

* El demo utiliza SES de AWS para el envío de correos, el dominio aún se encuentra en el Sandbox, lo que significa qué solo puede envíar emails a los correos especificados.
* ##### Aún no se crean las migraciones del modelo entidad relación, pero el endpoint para actualizar la información del usuario está funcionando con nombre y email. #####

##Development
| Status  |  Backlog |
|---|---|
| done  | Se requiere un WS para el login.
| done  | Se requiere un WS para registrar un nuevo usuario en el cual, la contraseña deberá de ser guardada de forma encriptada.
| done  | Se requiere un WS que envíe un correo a la dirección de email del usuario con un código de 6 dígitos random que servirá como contraseña temporal para iniciar sesión.
| done  | Se requiere un WS para actualizar la información del usuario.
| done  | Se requiere un WS para actualizar solo la contraseña del usuario, con verificación de la contraseña anterior, si la contraseña no coincide, no podrá actualizar la contraseña.
| in process  | Se requiere un WS para poder agregar a un amigo a la lista de amigos.
|   | Se requiere un WS para poder rechazar o aceptar a un amigo.
|   | Se requiere un WS para poder eliminar un amigo.
|   | Se requiere un WS que muestre un listado de todos los amigos que el usuario logueado tenga.
|   | Se requiere un WS que permita la creación de una minuta, cada minuta llevará múltiples acuerdos, múltiples participantes, los cuales podrán ser amigos anteriormente agregados y podrá contener o no evidencias (fotografías).
|   | Se requiere un WS que muestre un listado de las minutas donde el usuario haya sido participante o creador de la minuta.
|   | Se requiere un WS para poder actualizar una minuta en la cual el usuario logueado haya sido el creador.

## Importation
* Insomnia endpoints collection <a id="raw-url" href="https://raw.githubusercontent.com/DR-Edward/Minutas/master/importation/dev/Insomnia_2020-12-30.json">Raw file to download</a>
