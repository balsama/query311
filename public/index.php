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
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#tab_zip" type="button" role="tab" aria-controls="tab_zip" aria-selected="true">Search within Zip Code</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tab_address" type="button" role="tab" aria-controls="tab_address" aria-selected="false">Search by Address</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="tab_zip" role="tabpanel" aria-labelledby="home-tab">
                    <div class="input-group mb-3">
                       <div class="form-floating">
                        <input type="text" class="form-control" placeholder="Zip code" aria-label="zip-code" name="zip-code" id="zip-code">
                        <label class="form-label" for="case-title-contains">Zip code</label>
                    </div>
                       <div class="form-floating">
                        <select class="form-select" aria-label="case-title-contains" name="case-title-contains" id="case-title-contains">
                            <option selected="selected" value="">- Any -</option>
                            <option value="Bicycle">Abandoned Bicycle</option>
                            <option value="Building">Abandoned Building</option>
                            <option value="Vehicle">Abandoned Vehicle</option>
                            <option value="Bed Bugs">Bed Bugs</option>
                            <option value="Broken Park Equipment">Broken Park Equipment</option>
                            <option value="Broken Sidewalk">Broken Sidewalk</option>
                            <option value="Building Inspection Request">Building Inspection Request</option>
                            <option value="BWSC">BWSC</option>
                            <option value="atchbasin">Catchbasin</option>
                            <option value="E Collection">Code Enforcement Collection</option>
                            <option value="emetery Maintenance Request">Cemetery Maintenance Request</option>
                            <option value="omplaint">Complaint/Contractor Complaint</option>
                            <option value="onstruction Debris">Construction Debris</option>
                            <option value="Damaged Sign">Damaged Sign</option>
                            <option value="Dead Tree Removal">Dead Tree Removal</option>
                            <option value="Exceeding Terms of Permit">Exceeding Terms of Permit</option>
                            <option value="Fire">Fire Department Request</option>
                            <option value="General">General</option>
                            <option value="Graffiti">Graffiti</option>
                            <option value="Ground Maintenance">Ground Maintenance</option>
                            <option value="Heat">Heat (Excessive, Insufficient)</option>
                            <option value="Hero Square Sign Request">Hero Square Sign Request</option>
                            <option value="HP Sign">HP Sign</option>
                            <option value="Illegal Dumping">Illegal Dumping</option>
                            <option value="Illegal Graffiti">Illegal Graffiti</option>
                            <option value="Parking">Illegal Parking</option>
                            <option value="Improper Storage of Trash (Barrels)">Improper Storage of Trash (Barrels)</option>
                            <option value="Litter">Litter</option>
                            <option value="Mice">Mice Infestation (Residential)</option>
                            <option value="Missed">Missed Trash or Recycling</option>
                            <option value="Missing Sign">Missing Sign</option>
                            <option value="Needle">Needle Clean-up</option>
                            <option value="New Sign">New Sign, Crosswalk or Marking</option>
                            <option value="New Tree">New Tree Requests</option>
                            <option value="Notification">Notification</option>
                            <option value="Other">Other</option>
                            <option value="Park ">Park Maintenance</option>
                            <option value="Pigeon">Pigeon Infestation</option>
                            <option value="Poor Conditions of Property">Poor Conditions of Property</option>
                            <option value="Pothole">Pothole</option>
                            <option value="Protection of Adjoining Property">Protection of Adjoining Property</option>
                            <option value="Public Events">Public Events Noise Disturbances</option>
                            <option value="Public Works">Public Works General Request</option>
                            <option value="Rat">Rat</option>
                            <option value="Recycling Cart">Recycling Cart</option>
                            <option value="Plowing">Roadway Plowing/Salting</option>
                            <option value="Rodent">Rodent Sighting</option>
                            <option value="Bulk Item">Schedule a Bulk Item Pickup</option>
                            <option value="Senior Shoveling">Senior Shoveling</option>
                            <option value="Sewage">Sewage/Septic Back-Up</option>
                            <option value="Short Term Rental">Short Term Rental</option>
                            <option value="Sidewalk">Sidewalk</option>
                            <option value="Snow">Snow</option>
                            <option value="Space Savers">Space Savers</option>
                            <option value="Squalid">Squalid Living Conditions</option>
                            <option value="Street Light">Street Lights</option>
                            <option value="Move-In">Student Move-In Issues</option>
                            <option value="Traffic Signal">Traffic Signal</option>
                            <option value="Trash">Trash</option>
                            <option value="Tree Emergencies">Tree Emergencies</option>
                            <option value="Unsafe">Unsafe Dangerous Conditions</option>
                            <option value="Unsanitary">Unsanitary Conditions</option>
                            <option value="Unsatisfactory">Unsatisfactory Living Conditions</option>
                            <option value="Valet">Valet Parking Problems</option>
                            <option value="Work Hours">Work Hours-Loud Noise Complaints</option>
                            <option value="Work w/out Permit">Work w/out Permit</option>
                            <option value="Working Beyond Hours">Working Beyond Hours</option>
                            <option value="Zoning">Zoning</option>
                        </select>
                        </select>
                        <label class="form-label" for="case-title-contains">Category (optional)</label>
                    </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab_address" role="tabpanel" aria-labelledby="profile-tab">
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


            <button class="btn btn-outline-info" type="submit" value="search">Query</button>
        </form>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <script src="main.js"></script>
  </body>
</html>
