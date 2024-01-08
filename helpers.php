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

function loadView($name, $data = [])
{
    $viewPath = basePath("App/views/{$name}.view.php");
    if (!file_exists($viewPath)) {
        echo "View {$name} not found";
        return;
    }
    extract($data);
    require $viewPath;
}

/**
 * Load a partial
 * 
 * @param string $name
 * @return void
 */

function loadPartial($name)
{
    $partialPath = basePath("App/views/partials/{$name}.php");
    if (!file_exists($partialPath)) {
        echo "Partial {$name} not found";
        return;
    }
    require $partialPath;
}

/**
 * Inspect values
 * 
 * @param mixed $value
 * @return void
 */

function inspect($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

/**
 * Inspect values and die
 * 
 * @param mixed $value
 * @return void
 */

function inspectAndDie($value)
{
    echo '<pre>';
    die(var_dump($value));
    echo '</pre>';
}

/**
 * Formats the salary
 *
 * @param string $salary
 * @return string $formattedSalary
 */
function formatSalary($salary)
{
    if ($salary == 0 || is_null($salary)) return 'Not Disclosed';
    return '$' . number_format($salary, 0, '.', ',');
}


function sanitize($dirtyData)
{
    return htmlspecialchars(trim($dirtyData), FILTER_SANITIZE_SPECIAL_CHARS);
}
