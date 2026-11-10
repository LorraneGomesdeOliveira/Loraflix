<?php
function get_image_path($capa_url)
{
    $fallback = 'assets/img/fundo-cadastro.png';

    if (empty($capa_url)) {
        return $fallback;
    }

    $candidate = ltrim($capa_url, '/');
    $paths = [
        'assets/img/' . $candidate,
        'capas/' . $candidate,
        $candidate,
    ];

    foreach ($paths as $path) {
        if (file_exists($path)) {
            return $path;
        }
    }

    return $fallback;
}
?>
