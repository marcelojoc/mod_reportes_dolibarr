## Proyecto modulo complementario de Reportes Dolibarr


Modulo de reportes de ventas por producto y por cliente.


### tecnologias

Uso de tecnologias open source:

* [PHP] - Lenguaje de servidor
* [Mysql] - Motor de base de datos
* [Dolibarr](https://www.dolibarr.es) - plataforma de gestion
* [Twitter Bootstrap] - framework html5
* [jQuery] - :(


### Instalacion

  - El directorio debe copiarse en el raiz de modulos de Doibarr
  - Desde el administrador de modulos debes activar el mismo


> los vendedores poseen paramentros adicionales 
> que son utilizados por el modulo 
> Cada vendedor posee campos adicionales que deben ser agregados


Usuarios:


| etiqueta | Codigo | tipo | valor |
| ------ | ------ | ------ | ------ |
| Almacen | warehouse | Lista desde una tabla | entrepot:label |
| numero Vendedor | codvendedor | Numérico | entrepot:label |
| caja_vendedor | caja | Lista desde una tabla | bank_account:label |



Terceros:


| etiqueta | Codigo | tipo | valor | requerido |
| ------ | ------ | ------ | ------ | ------ |
| Ruta | ruta1 | Numérico | 2 | si |
| Vendedor | vendedor | Numérico | 2 | si |




License
----

MIT
