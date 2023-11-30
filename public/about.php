<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Boston 311 Search</title>
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
    <meta property="og:image" content="favicon/311Query.png" />
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
    <h1>About Boston 311 records search</h1>
    <p class="fs-5">This site helps you to search Boston's 311 records.</p>
    <p>It directly queries the 311 Service Requests dataset from data.boston.gov via the CKAN Data API provided by the City.</p>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="main.js"></script>
</body>
</html>