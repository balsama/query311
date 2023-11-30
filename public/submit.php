<?php

include_once __DIR__ . "/../vendor/autoload.php";

use Balsama\Fetch;
use Balsama\Query311\Query311Builder;

$query = new Query311Builder($_GET);
$sql = $query->getQuery();

$url = "https://data.boston.gov/api/3/action/datastore_search_sql?sql=" . $sql;
$result = Fetch::fetch($url);

$records = $result->result->records;
$records = array_reverse($records);
$count = count($records);

$template = <<<EOD
<div class="col">
<div class="card mb-2" style="width: 18rem;">
  <span class="badge bg-{{COLOR}} position-absolute top-0 end-0 m-1">{{STATUS}}</span>
  <img src="{{IMAGE}}" class="card-img-top img-thumbnail" alt="...">
  <div class="card-body">
    <h5 class="card-title">{{TITLE}}</h5>
    <p>{{ADDRESS}}</p>
    <ul class="list-group list-group-flush">
        <li class="list-group-item small">Opened: {{OPENED}}</li>
        <li class="list-group-item small">Closed: {{CLOSED}}</li>
    </ul>
    <p class="card-text">{{BODY}}</p>
    <a href="{{LINK}}" class="btn btn-primary">View case</a>
  </div>
</div>
</div>
EOD;
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>311 Query Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@balsama" />
    <meta name="twitter:creator" content="@balsama" />
    <meta property="og:url" content="http://localhost/query311/public/" />
    <meta property="og:title" content="Boston 311 Records Search" />
    <meta property="og:description" content="A tool to help you to search Boston's 311 records." />
    <meta property="og:image" content="https://query311-41292d25d8ea.herokuapp.com/favicon/311Query.png" />
</head>
<body class="d-flex flex-column h-100">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container">
    <a class="navbar-brand" href="index.php">Boston 311 Record Search</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
                <a class="nav-link" aria-current="page" href="index.php">Search by Zip Code and Case title</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="by-address.php">Search by address</a>
            </li>
        </ul>
    </div>
</div>
</nav>
<main class="flex-shrink-0">
<div class="container">
    <p class="shadow bg-dark py-1 px-2"><span class="text-secondary">Query:</span><br><code><span class="text-info"><?php echo $sql; ?></span></code></p>
    <h1>Results:</h1>
    <p><strong class="text-primary"><?php print number_format($count); ?></strong> records match your search:</p>
    <div class="row">
    <?php
    foreach ($records as $record) {
        $image = !$record->closed_photo ? 'https://placehold.co/600x400?text=Bos+311' : $record->closed_photo;
        $status = $record->case_status;
        $color = $status === 'Closed' ? 'success' : 'warning';
        $item = str_replace(
            [
                '{{IMAGE}}',
                '{{TITLE}}',
                '{{BODY}}',
                '{{LINK}}',
                '{{STATUS}}',
                '{{COLOR}}',
                '{{ADDRESS}}',
                '{{OPENED}}',
                '{{CLOSED}}',
            ],
            [
                $image,
                $record->type,
                $record->closure_reason,
                "https://311.boston.gov/tickets/" . $record->case_enquiry_id,
                $status,
                $color,
                $record->location,
                $record->open_dt,
                $record->closed_dt,
            ],
            $template
        );
        echo $item;
    }
    ?>
    </div>
</div>
</main>
</body>
</html>

