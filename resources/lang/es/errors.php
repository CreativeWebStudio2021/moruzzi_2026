<?php

return [
    '404' => [
        'meta_title' => 'Página no encontrada',
        'meta_description' => 'La página solicitada no existe o ya no está disponible.',
        'heading' => 'Página no encontrada',
        'message' => 'La página que buscas no existe, ha sido eliminada o la dirección introducida no es correcta.',
        'home' => 'Volver al inicio',
        'catalog' => 'Explorar el catálogo',
        'contacts' => 'Contacto',
    ],
    '500' => [
        'meta_title' => 'Error del servidor',
        'meta_description' => 'Se ha producido un error temporal. Inténtalo de nuevo en unos instantes.',
        'heading' => 'Error del servidor',
        'message' => 'Algo ha fallado en nuestro sitio. Estamos trabajando para solucionarlo: inténtalo de nuevo en breve o vuelve al inicio.',
        'home' => 'Volver al inicio',
        'contact' => 'Contáctanos',
    ],
    '503' => [
        'meta_title' => 'Servicio no disponible',
        'meta_description' => 'El sitio no está disponible temporalmente. Inténtalo más tarde.',
        'heading' => 'Servicio no disponible',
        'message' => 'El sitio no está accesible temporalmente por mantenimiento o alta demanda. Te invitamos a intentarlo de nuevo en unos minutos.',
        'home' => 'Volver al inicio',
        'retry' => 'Reintentar',
    ],
];
