<?php
include_once __DIR__ . '/../vendor/autoload.php';
use Balsama\Query311\Helpers;
?>
<!doctype html>
<html lang="en">
  <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>Search Boston 311</title>
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
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="index.php">
          <img src="favicon/logo-light.png" alt="Bootstrap" width="40" height="40">
        </a>
        <a class="navbar-brand" href="index.php">Boston 311 Record Search</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Search</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.php">About</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container my-5">
      <h1>Search Boston 311 records</h1>
      <div class="col-lg-8 px-0">

        <form method="get" enctype="multipart/form-data" action="submit.php" name="type">

            <div class="form-floating">
                <select class="form-select form-select-lg mb-3" name="table" id="yearselect" aria-label="Default select example" onchange="updateDateFields(event)">
                    <?php
                    foreach (Helpers::YEAR_UUID_MAP as $year => $uuid) {
                        echo "<option value='$year'>$year</option>";
                    }
                    ?>
                </select>
                <label class="form-label" for="yearselect">Year to search</label>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active show" id="home-tab" data-bs-toggle="tab" data-bs-target="#tab_zip" type="button" role="tab" aria-controls="tab_zip" aria-selected="true">Search within Zip Code</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab_address" type="button" role="tab" aria-controls="tab_address" aria-selected="false">Search by Address</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane active" id="tab_zip" role="tabpanel" aria-labelledby="home-tab">
                    <div class="input-group mb-3">
                       <div class="form-floating">
                        <input type="text" class="form-control" placeholder="Zip code" aria-label="zip-code" name="zip-code" id="zip-code">
                        <label class="form-label" for="case-title-contains">Zip code</label>
                    </div>
                       <div class="form-floating">
                        <select class="form-select" aria-label="case-title-contains" name="case-title-contains" id="case-title-contains">
                            <?php echo Helpers::getCategoryOptionsHtml(); ?>
                        </select>
                        </select>
                        <label class="form-label" for="case-title-contains">Category (optional)</label>
                    </div>
                    </div>
                </div>
                <div class="tab-pane" id="tab_address" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Address contains" aria-label="address-contains" name="address-contains" id="address-contains">
                        <label class="form-label" for="address-contains">Address (starts with)</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="address-search-type" name="address-search-type">
                            <label class="form-check-label" for="address-search-type">Address "contains" (default: "starts with")</label>
                        </div>
                        <small class="text-muted">Case sensitive. Try <code>36 Hull</code> or <code>55 Boutwell</code>, for example</small>
                    </div>
                </div>
            </div>

            <div class="input-group mb-3">
            <div class="form-floating">
                <input type="date" class="form-control" value="2023-01-01" aria-label="date-after" name="date-after" id="date-after">
                <label class="form-label" for="date-after">Date is after (must be within year selected above)</label>
            </div>
            <div class="form-floating">
                <input type="date" class="form-control" value="2023-12-31" aria-label="date-before" name="date-before" id="date-before">
                <label class="form-label" for="date-before">...and date is before</label>
            </div>
            </div>

            <button class="btn btn-primary btn-lg" type="submit" value="search">Search</button>
            <a href="index.php" class="btn btn-outline-primary btn-lg">Reset</a>
        </form>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="main.js"></script>
  </body>
</html>
