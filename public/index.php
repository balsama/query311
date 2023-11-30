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
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="index.php">Boston 311 Record Search</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="index.php">Search by Zip Code and Case title</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="by-address.php">Search by address</a>
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
                <label class="form-label" for="table">Year to search</label>
            </div>

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#tab_zip" type="button" role="tab" aria-controls="tab_zip" aria-selected="true">Search within Zip Code</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab_address" type="button" role="tab" aria-controls="tab_address" aria-selected="false">Search by Address</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab_zip" role="tabpanel" aria-labelledby="home-tab">
                    <div class="form-floating">
                        <input type="text" class="form-control" placeholder="Zip code" aria-label="zip-code" name="zip-code" id="zip-code">
                        <label class="form-label" for="case-title-contains">Zip code</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control mt-3" placeholder="Case title contains" aria-label="case-title-contains" name="case-title-contains" id="case-title-contains">
                        <label class="form-label" for="case-title-contains">Case title contains (optional)</label>
                        <small class="text-muted mb-3">Case sensitive. Try <code>Trash</code>, <code>Rodent</code>, or <code>Unsatisfactory</code></small>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab_address" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" placeholder="Address contains" aria-label="address-contains" name="address-contains" id="address-contains">
                        <label class="form-label" for="address-contains">Address (starts with)</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="address-search-type" name="address-search-type">
                            <label class="form-check-label" for="count">Address "contains" (default: "starts with")</label>
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


            <button class="btn btn-outline-info" type="submit" value="search">Query</button>
        </form>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="main.js"></script>
  </body>
</html>
