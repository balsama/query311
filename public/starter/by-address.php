<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
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
                    <a class="nav-link" href="index.php">Search by Zip Code and Case title</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="by-address.php">Search by address</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h1>Query!</h1>
    <div class="col-lg-8 px-0">

        <form method="post" enctype="multipart/form-data" action="submit.php">

            <div class="form-check">
                <input class="form-check-input" type="radio" name="table" value="e6013a93-1321-4f2a-bf91-8d8a02f1e62f" id="2023" checked>
                <label class="form-check-label" for="2023">2023</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="table" value="81a7b022-f8fc-4da5-80e4-b160058ca207" id="2022">
                <label class="form-check-label" for="2022">2022</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="table" value="f53ebccd-bc61-49f9-83db-625f209c95f5" id="2021">
                <label class="form-check-label" for="2021">2021</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="table" value="6ff6a6fd-3141-4440-a880-6f60a37fe789" id="2020">
                <label class="form-check-label" for="2020">2020</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="table" value="ea2e4696-4a2d-429c-9807-d02eb92e0222" id="2019">
                <label class="form-check-label" for="2019">2019</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="table" value="2be28d90-3a90-4af1-a3f6-f28c1e25880a" id="2018">
                <label class="form-check-label" for="2018">2018</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="table" value="30022137-709d-465e-baae-ca155b51927d" id="2017">
                <label class="form-check-label" for="2017">2017</label>
            </div>


            <label class="form-label" for="address-contains">Address (starts with)</label>
            <input type="text" class="form-control" placeholder="Address contains" aria-label="address-contains" name="address-contains" id="address-contains">
            <p>Case sensitive. Try <code>36 Hull</code> or <code>55 Boutwell</code>, for example</p>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="address-search-type" name="address-search-type">
                <label class="form-check-label" for="count">Address "contains" (default: "starts with")</label>
            </div>

            <button class="btn btn-outline-info" type="submit" name="by-address">Query</button>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="main.js"></script>
</body>
</html>
