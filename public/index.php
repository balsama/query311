<?php

use Balsama\Query311\Helpers;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new FilesystemLoader('templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../twig-cache',
    'debug' => Helpers::getVars()['debug'],
]);

$year_options = [];
foreach (Helpers::YEAR_UUID_MAP as $year => $uuid) {
    $year_options[] = "<option value='$year'>$year</option>";
}
$year_options = implode("\n", $year_options);
$category_options = Helpers::getCategoryOptionsHtml();

$page_template = $twig->load('page.twig');
$nav_template = $twig->load('nav.twig');
$nav = $nav_template->render([
    'l1_classes' => 'nav-link active',
    'l2_classes' => 'nav-link',
]);
$form_template = $twig->load('form.twig');
$form = $form_template->render([
    'year_options' => $year_options,
    'category_options' => $category_options,
]);

echo $page_template->render([
    'nav' => $nav,
    'title' => 'Search Boston 311 records!',
    'body' => $form
]);