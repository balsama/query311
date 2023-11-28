<?php

include_once __DIR__ . "/../../vendor/autoload.php";

use Balsama\Fetch;

$query = new \Balsama\Query311\Query311Builder($_POST);

$url = "https://data.boston.gov/api/3/action/datastore_search_sql?sql=" . $query->getQuery();

$result = Fetch::fetch($url);

$records = $result->result->records;
$records = array_reverse($records);
$count = count($records);

$template = <<<EOD
<div class="col">
<div class="card" style="width: 18rem;">
  <img src="{{IMAGE}}" class="card-img-top img-thumbnail" alt="...">
  <div class="card-body">
    <h5 class="card-title">{{TITLE}}</h5>
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Results:</h1>
    <p>
    <strong class="text-primary"><?php print number_format($count); ?></strong> records match your search:
    </p>
    <div class="row">
    <?php
    foreach ($records as $record) {
        if (!$record->closed_photo) {
            $image = 'https://placehold.co/600x400?text=Bos+311';
        }
        else {
            $image = $record->closed_photo;
        }
        $item = str_replace(['{{IMAGE}}', '{{TITLE}}', '{{BODY}}', '{{LINK}}'], [$image, $record->open_dt . $record->case_enquiry_id . $record->type, $record->closure_reason, "https://311.boston.gov/tickets/" . $record->case_enquiry_id], $template);
        echo $item;
    }
    ?>
    </div>
</div>
</body>
</html>

