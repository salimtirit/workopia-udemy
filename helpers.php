<?php

/**
 * Get the base path
 * 
 * @param string $path
 * @return string
 */
function basePath($path = '')
{
    return __DIR__ . '/' . $path;
}

/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */

function loadView($name)
{
    $viewPath = basePath("views/{$name}.view.php");
    if (!file_exists($viewPath)) {
        echo "View {$name} not found";
        return;
    }
    require $viewPath;
}

/**
 * Load a view
 * 
 * @param string $name
 * @return void
 */

function loadPartial($name)
{
    $partialPath = basePath("views/partials/{$name}.php");
    if (!file_exists($partialPath)) {
        echo "Partial {$name} not found";
        return;
    }
    require $partialPath;
}
