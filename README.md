# Simple SEO & Meta Manager - toolkitAC

## Creador

Desarrollado por Anderson Chila.

Portafolio profesional: https://anderson526.github.io/portfolio-profesional/

## Lenguaje y stack técnico

- PHP 7.4+
- WordPress 6.x
- Gutenberg editor API
- JavaScript para panel lateral del editor
- CSS para estilos del panel
- Hooks del núcleo de WordPress y metadatos personalizados

## Uso

1. Instala el plugin en wp-content/plugins/.
2. Actívalo desde la sección de plugins de WordPress.
3. Abre cualquier entrada, página o CPT público.
4. Completa el panel "AC SEO" del editor de bloques.
5. Guarda el contenido y revisa que el título y las meta etiquetas se generen correctamente en el frontend.

Simple SEO & Meta Manager - toolkitAC es un plugin de WordPress para gestionar metadatos SEO básicos en el editor de bloques de Gutenberg. Su enfoque es mínimo y técnico: permite definir un título SEO personalizado y una meta descripción por contenido, y los inyecta automáticamente en el frontend sin añadir complejidad ni dependencias adicionales.

El plugin está orientado a sitios que requieren una solución ligera para control manual de SEO on-page, con soporte para tipos de contenido públicos y serialización nativa a través de meta fields compatibles con REST.

## Descripción

El plugin registra dos campos de metadatos por tipo de contenido público:

- `_anderc_seo_title`: título SEO personalizado
- `_anderc_seo_desc`: meta descripción personalizada

Estos valores se usan para:

- reemplazar el título del documento en el frontend
- generar la etiqueta `<meta name="description">`
- generar etiquetas Open Graph (`og:title`, `og:description`, `og:url`, etc.)
- generar tarjetas de Twitter (`twitter:title`, `twitter:description`, `twitter:card`)

Además, incorpora un panel lateral dentro del editor de bloques para definir estos valores sin salir del flujo editorial.

## Características principales

- Panel lateral "AC SEO" en el editor de bloques
- Título SEO editable para entradas, páginas y tipos de contenido públicos
- Meta descripción editable con validación visual de longitud
- Reemplazo del título del documento mediante el filtro `document_title_parts`
- Generación de metadatos Open Graph y Twitter Card en `wp_head`
- Fallback a `wp_get_document_title()` y a un extracto limpio cuando no existe descripción personalizada
- Registro de metadatos con `register_post_meta()` y soporte `show_in_rest`
- Compatibilidad con Gutenberg y WordPress 6.x
- Sin proceso de compilación ni dependencias externas adicionales
- Módulo opcional de donaciones desde el panel administrativo

## Requisitos

- WordPress 6.0 o superior
- PHP 7.4 o superior
- Acceso administrativo para editar metadatos del contenido

## Instalación

1. Descarga o clona este repositorio dentro de la carpeta `wp-content/plugins/` de tu instalación de WordPress.
2. Asegúrate de que la carpeta final se llame `simple-seoAC`.
3. En el panel de administración de WordPress, ve a Plugins > Plugins instalados.
4. Busca "Simple SEO & Meta Manager - toolkitAC" y activa el plugin.
5. Abre cualquier entrada, página o tipo de contenido público en el editor de bloques.
6. En la barra lateral del editor, localiza el panel "AC SEO".

## Uso

### 1. Definir título SEO

En el panel "AC SEO" del editor, completa el campo "Título SEO".

Este valor reemplaza el título del documento cuando se renderiza la vista pública. Si el campo queda vacío, el plugin usa el título estándar de WordPress.

### 2. Definir meta descripción

Completa el campo "Meta descripción" con un resumen claro y conciso del contenido.

El valor se imprime como:

- `<meta name="description">`
- `og:description`
- `twitter:description`

Si no se define, el plugin intenta generar una descripción a partir del extracto del contenido usando `wp_trim_words()` y `wp_strip_all_tags()`.

### 3. Vista pública

Una vez guardado el contenido, el plugin inyecta los metadatos en el `<head>` de la página mediante la acción `wp_head` y ajusta el título del documento con el filtro `document_title_parts`.

Los valores también están disponibles para la API REST porque el plugin registra los metadatos con `show_in_rest => true`.

### 4. Tipos de contenido compatibles

El plugin habilita el soporte para todos los tipos de contenido públicos, excluyendo adjuntos (`attachment`).

Esto permite aplicar la funcionalidad a:

- entradas
- páginas
- tipos de contenido personalizados públicos

## Estructura del plugin

- `simple-seoAC.php`: archivo principal del plugin y bootstrap
- `includes/class-aseo-plugin.php`: inicialización central del plugin y definición de tipos de contenido compatibles
- `includes/class-aseo-meta-fields.php`: registro de metadatos con permisos y soporte REST
- `includes/class-aseo-editor.php`: carga del panel en el editor de bloques
- `includes/class-aseo-frontend-output.php`: inyección de metadatos y título del documento en el frontend
- `includes/class-aseo-donations.php`: página administrativa opcional de apoyo
- `assets/js/editor-sidebar.js`: interfaz del panel de edición en Gutenberg
- `assets/css/editor.css`: estilos del panel de administración del editor

## Metadatos registrados

El plugin registra los siguientes post meta:

- `_anderc_seo_title`
- `_anderc_seo_desc`

Estos se definen con tipo `string`, sanitización apropiada y permisos de edición del usuario actual.

## Integración técnica

El comportamiento principal se basa en hooks nativos de WordPress:

- `document_title_parts` para adaptar el `<title>`
- `wp_head` para imprimir etiquetas meta y Open Graph
- `enqueue_block_editor_assets` para cargar la UI del editor
- `init` para registrar metadatos y texto traducible

La arquitectura es mínima y no depende de un sistema de gestión de estado externo ni de un compilador de assets. La interactividad del panel del editor se implementa con objetos globales de WordPress (`wp.plugins`, `wp.editPost`, `wp.components`, `wp.data` y `wp.i18n`).

## Fallback y comportamiento por defecto

Cuando no se define un título SEO personalizado, el plugin conserva el comportamiento estándar de WordPress usando `wp_get_document_title()`.

Cuando no se define una meta descripción:

- se intenta extraer un resumen del contenido
- se sanitiza el texto con `wp_strip_all_tags()`
- se limita el texto con `wp_trim_words()`

Los valores de Open Graph y Twitter se generan con un contenido basado en el título y la descripción validada.

## Autor

Este plugin fue desarrollado por Anderson Chila.

- Sitio profesional: https://anderson526.github.io/portfolio-profesional/
- Nombre del autor: Anderson Chila
- Texto del dominio: `anderc-simple-seo`

## Licencia

Este plugin está licenciado bajo GPL-2.0-or-later.

## Notas de uso

Este plugin está diseñado para casos de uso de SEO esencial y manual. No reemplaza herramientas avanzadas de SEO, análisis semántico, análisis de keywords, generación de schema.org ni auditorías completas de rendimiento SEO.

Su intención es ofrecer una capa de control técnico y clara sobre los metadatos más relevantes para motores de búsqueda y redes sociales, manteniendo el flujo de trabajo dentro del editor de WordPress.

## Soporte de donaciones

El plugin incluye una página administrativa opcional para apoyo financiero. Se encuentra en:

- `wp-admin/admin.php?page=anderc-simple-seo-donations`

La página presenta un enlace directo a PayPal para colaborar con el mantenimiento del proyecto.

## Agradecimiento

Gracias a la comunidad de WordPress, a la comunidad PHP y a quienes revisan el portafolio del creador. Este proyecto nació con la intención de ofrecer SEO útil, claro y visualmente sencillo para cualquier contenido editorial.
