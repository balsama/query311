<?php

use Balsama\Fetch;
use Balsama\Query311\Helpers;
use Balsama\Query311\Query311Builder;
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
    'l2_classes' => 'nav-link active',
]);

$body = <<<EOD
    <p class="fs-5">This site helps you search Boston's 311 records.</p>
    <p>It directly queries the 311 Service Requests dataset from data.boston.gov via the <a href="https://data.boston.gov/api/1/util/snippet/api_info.html?resource_id=e6013a93-1321-4f2a-bf91-8d8a02f1e62f">CKAN Data API</a> provided by the City.</p>
    <h3>Limitations</h3>
    <ul>
        <li><strong>Available fields</strong>: The City doesn't provide certain fields such as the original description or the submitted photo via the API. So you can't search for text that used by the submitter.</li>
        <li><strong>Restricted records</strong>: A link to the City's web presentation of each returned record is provided on the results page. For some reason, the City restricts access to certain (many) records even though they are returned via tha API. So you may see a 404 when you try to view the City's record.</li>
    </ul>
    <h3>Questions</h3>
    <ul>
        <li><strong>Bug reports</strong>: File bug reports and feature requests via the <a href="https://github.com/balsama/query311">GitHub Repo</a></li>
        <li><strong>Contact</strong>: Contact the developer via <a href="https://twitter.com/balsama">Twitter</a>.</li>
    </ul>
EOD;

echo $page_template->render([
    'page_title' => 'About Boston 311 records search',
    'nav' => $nav,
    'title' => 'Results',
    'body' => $body,
]);
