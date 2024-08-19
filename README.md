# Documentación del Proyecto

## Instrucciones

1. **Crea un repositorio en GitHub**: Genera un nuevo repositorio en GitHub para este proyecto.

2. **Realiza los siguientes ejercicios**: Completa los ejercicios descritos a continuación.

## Formato de Entrega

- Al finalizar, sube todo el proyecto al repositorio creado.
- Comparte el enlace del repositorio con el usuario `makroz@hotmail.com` para que pueda clonar y revisar tu trabajo.

## Informar al Finalizar la Entrega

Envía un correo electrónico a los siguientes destinatarios para informar que has terminado la entrega:

- **CEO**: [douglasdiez@condaty.com](mailto:douglasdiez@condaty.com)
- **COO**: [brendamel.fos@gmail.com](mailto:brendamel.fos@gmail.com)
- **Copia**:
  - Encargada de Recursos Humanos: [karen.rocha.fos@gmail.com](mailto:karen.rocha.fos@gmail.com)

## Ejercicios

### Ejercicio 1: CRUD de Productos

Crea un CRUD (Create, Read, Update, Delete) para la entidad "Producto".

#### Requisitos

- Un producto debe tener los siguientes campos: `id`, `nombre`, `descripción`, `precio`, `cantidad`, `created_at`, `updated_at`.
- Implementa las rutas, controladores y vistas necesarias para crear, leer, actualizar y eliminar productos.
- Utiliza validaciones en el controlador para asegurarte de que los datos son correctos antes de guardarlos en la base de datos.

### Ejercicio 2: Relación entre Tablas

Crea una relación entre los productos y las categorías.

#### Requisitos

- Una categoría debe tener los siguientes campos: `id`, `nombre`, `descripción`, `created_at`, `updated_at`.
- Un producto puede pertenecer a una sola categoría, y una categoría puede tener muchos productos.
- Implementa las migraciones necesarias para crear las tablas y sus relaciones.
- En el formulario de creación y edición de productos, añade un select para seleccionar la categoría del producto.

### Ejercicio 3: Subida de Imágenes

Añade la funcionalidad para subir imágenes de los productos.

#### Requisitos

- Un producto puede tener una imagen asociada.
- Al crear o editar un producto, debe haber un campo para subir una imagen.
- Guarda las imágenes en el storage de Laravel.
- Muestra la imagen del producto en la vista de detalle y listado de productos.

### Ejercicio 4: API REST

Crea una API REST para gestionar los productos.

#### Requisitos

- Implementa las rutas y controladores necesarios para realizar operaciones CRUD mediante la API.
- Las rutas deben ser `/api/productos`, `/api/productos/{id}` para los endpoints de productos.
- Asegúrate de devolver las respuestas en formato JSON.
- Añade validaciones a las peticiones.

### Ejercicio 5: Autenticación

Implementa un sistema de autenticación básico.

#### Requisitos

- Utiliza la autenticación proporcionada por Laravel para permitir a los usuarios registrarse y autenticarse.
- Protege las rutas del CRUD de productos para que solo los usuarios autenticados puedan acceder a ellas.
- Añade middleware para redirigir a los usuarios no autenticados a la página de inicio de sesión.

