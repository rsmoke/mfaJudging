<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContestJudging.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isJudge = false;
$_SESSION["isJudge"] = 0;

$sql = <<< _SQL
  SELECT *
  FROM tbl_contestjudge
  WHERE uniqname = '$login_name'
  ORDER BY uniqname
_SQL;

if (!$resJudge = $db->query($sql)) {
        db_fatal_error("data read issue", $db->error);
        exit;
}

if ($resJudge->num_rows > 0) {
    $isJudge = true;
    $_SESSION["isJudge"] = 1;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>LSA-<?php echo "$contestTitle";?> Writing Contests</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="LSA-English Writing Contests">
  <meta name="keywords" content="LSA-English, Hopwood, Writing, UniversityofMichigan">
  <meta name="author" content="LSA-MIS_rsmoke">
  <link rel="icon" href="img/favicon.ico">

<!--   <script type='text/javascript' src='../js/webforms2.js'></script> -->

  <link rel="stylesheet" href="css/bootstrap.min.css"><!-- 3.3.1 -->
  <link rel="stylesheet" href="css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/normalize.css" media="all">
  <link rel="stylesheet" href="css/default.css" media="all">

  <style type="text/css">
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance:textfield;
    }
  </style>
  <base href=<?php echo URL ?>>
</head>

<body>
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
          <div class="container">
          <div class="navbar-header">
             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php"><?php echo "$contestTitle";?></a>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
              <li class="dropdown">
                 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Signed in as <?php echo $login_name;?><strong class="caret"></strong></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="index.php"><?php echo "$contestTitle";?> main</a>
                  </li>
                  <li>
                    <a href="https://weblogin.umich.edu/cgi-bin/logout">logout</a>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
          </div>
        </nav>

    <?php if ($isJudge) {
        ?>
<div class="container"><!-- container of all things -->
<div class="jumbotron">
  <h1>Judging Instructions</h1>
  <p class="bg-warning">Please read and understand the instructions below before submitting any evaluations.</p>
  <p>
    There are two stages to the evaluation process.
    <ol>
      <li>The first stage is reading the entries and giving them a rating from 1 to 5 stars. You are also 
      able to write a comment about the entry and save it with the rating. You need to provide a rating for all entries 
      in the contest area you have been assigned. <u>Only rated entries will move forward to the ranking stage.</u> This 
      stage can be accessed by selecting <a id="ratingsample" class="btn btn-primary btn-xs disabled fa fa-star"> Rating</a> below.</li>
      <li>The second stage of the judging process is ranking the entries that you rated in the previous step. You will
      see a list of all the entries for a given contest sorted by the top rated down to the lowest rated entry. You will
      give, what you consider to be the top 10 entries, a ranking with the best ranked as #1. You are able to leave a commment 
      in the ranking section. This stage can be accessed by selecting <a id="rankingsample" class="btn btn-success btn-xs disabled fa fa-sort-numeric-asc"> Ranking</a></li>
    </ol>
    <div class="btn-toolbar">
      <div class="btn-group" role="group" aria-label="button group">
        <a class="btn btn-primary fa fa-star" href="rating.php" role="button"> Rating</a>
        <a class="fa fa-sort-numeric-asc btn btn-success " href="ranking.php" role="button"> Ranking</a>
      </div>
      <div class="btn-group" role="group" aria-label="button group">
        <a class="btn btn-warning fa fa-info-circle" href="http://lsa.umich.edu/hopwood/contests-prizes.html" role="button" target="_blank"> Contest Rules</a>
      </div>
    </div>
  </p>
  <p>
    The following is a list of the icons that you will see throughout the application
    <ul>
      <li><span class="fa fa-book disabled"></span> the link to the reading associated with a particular entry</li>
    </ul>
  </p>

  <p>Do not hesite to ask questions
  <ul class="list-inline">
  <li>
    <address>
      <strong>Andrea Beauchamp</strong><br>
      Assistant Director, Hopwood Awards Program<br>
      <abbr title="eMail">e:</abbr><a href="mailto:abeauch@umich.edu">abeauch@umich.edu</a>
    </address>
  </li>
  <li></li>
  <li>
    <address>
      <strong>Rick Smoke</strong><br>
      Application Architect, LSA-<abbr title="Management Information Systems">MIS</abbr><br>
      <abbr title="eMail">e:</abbr><a href="mailto:rsmoke@umich.edu">rsmoke@umich.edu</a>
    </address>
  </li>
  </ul>
  </p>
</div>

<?php
} else {
?>

  <!-- if there is not a record for $login_name display the basic information form. Upon submitting this data display the contest available section -->
  <div id="notAdmin">
    <div class="row clearfix">
      <div class="col-md-12">

          <div id="instructions" style="color:sienna;">
            <h1 class="text-center" >You are not authorized to this space!!!</h1>
            <h4>University of Michigan - LSA Computer System Usage Policy</h4>
            <p>This is the University of Michigan information technology environment. You
            MUST be authorized to use these resources. As an authorized user, by your use
            of these resources, you have implicitly agreed to abide by the highest
            standards of responsibility to your colleagues, -- the students, faculty,
            staff, and external users who share this environment. You are required to
            comply with ALL University policies, state, and federal laws concerning
            appropriate use of information technology. Non-compliance is considered a
            serious breach of community standards and may result in disciplinary and/or
            legal action.</p>
            <div style="postion:fixed;margin:10px 0px 0px 250px;height:280px;width:280px;"><a href="http://www.umich.edu"><img alt="University of Michigan" src="img/michigan.png" /> </a></div>
          </div><!-- #instructions -->
      </div>
    </div>
  </div>

    <?php
}
    include("footer.php");?>
    <!-- //additional script specific to this page -->
      <script src="js/jdgMyScript.js"></script>
</div><!-- End Container of all things -->
</body>
</html>

<?php
  $db->close();
