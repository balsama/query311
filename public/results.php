<?php

use Balsama\Fetch;
use Balsama\Query311\Helpers;
use Balsama\Query311\Query311Builder;
use Balsama\Query311\QueryParameters;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once __DIR__ . '/../vendor/autoload.php';

$loader = new FilesystemLoader('templates');
$twig = new Environment($loader, [
    'cache' => __DIR__ . '/../twig-cache',
    'debug' => Helpers::getVars()['debug'],
]);

$page_template = $twig->load('page.twig');
$nav_template = $twig->load('nav.twig');
$nav = $nav_template->render([
    'l1_classes' => 'nav-link',
    'l2_classes' => 'nav-link',
]);

if (!array_key_exists('table', $_GET)) {
    return print $page_template->render([
        'page_title' => '311 Search | error',
        'nav' => $nav,
        'title' => 'Error',
        'body' => '<p>Error: no form data provided.</p><p>Use the <a href="index.php">form</a> to search.</p>',
    ]);
    return print "<h1>Search Boston 311</h1><p>Error: no form data provided.</p><p>Use the <a href='index.php'>form</a> to search.</p>";
}

$queryParameters = new QueryParameters($_GET);
$query = new Query311Builder($queryParameters);
$sql = $query->getQuery();

$url = "https://data.boston.gov/api/3/action/datastore_search_sql?sql=" . $sql;
$result = Fetch::fetch($url);

$records = $result->result->records;
$records = array_reverse($records);
$count = count($records);

$body_pre = "<p class='shadow bg-dark py-1 px-2'><span class='text-secondary'>Query:</span><br><code><span class='text-info'>$sql</span></code></p>";

$body_top = "<p><strong class='text-primary'>$count</strong> records match your search:</p>";


$card_template = $twig->load('card.twig');
$cards = [];
foreach ($records as $record) {
    preg_match('/Case Closed\. Closed date : \d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\.\d{1,3} /', $record->closure_reason, $matches);
    $closedNotes = $matches ? substr($record->closure_reason, strlen($matches[0])) : $record->closure_reason;

    $cards[] = $card_template->render([
        'IMAGE' => !$record->closed_photo ? 'https://placehold.co/600x400?text=Bos+311' : $record->closed_photo,
        'TITLE'=> $record->type,
        'BODY' => $closedNotes,
        'RECORD_ID' => $record->case_enquiry_id,
        'STATUS' => $record->case_status,
        'COLOR' => $record->case_status === 'Closed' ? 'success' : 'warning',
        'ADDRESS' => $record->location,
        'OPENED' => $record->open_dt,
        'CLOSED' => $record->closed_dt,
    ]);
}

echo $page_template->render([
    'page_title' => '311 Search Results',
    'nav' => $nav,
    'title' => 'Results',
    'body_pre' => $body_pre,
    'body_top' => $body_top,
    'body' => '<div class="row">' . implode("\n", $cards) . '</div>',
]);