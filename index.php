<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContestJudging.php';
require_once $_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($isJudge) {

    ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>LSA-<?php echo "$contestTitle"; ?> Writing Contests</title>
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
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php"><?php echo "$contestTitle"; ?><span style="color:#00FF80"> - Judging</span></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Signed in as <?php echo $login_name; ?><strong class="caret"></strong></a>
              <ul class="dropdown-menu">
                <li>
                  <a href="index.php"><?php echo "$contestTitle"; ?> main</a>
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

    <div id="mainContainer" class="container"><!-- container of all things -->
    <div class="page-header">
      <h1>Judging Instructions</h1>
      <p class="bg-warning">Please read and understand the instructions below before submitting any evaluations.</p>
      <p>
        There is only one stage to the evaluation process.
        <ul>
          <li>You will be reading the entries and giving them a value of 1 to 10 with 1 being the best or highest.</li>
          <li>You need to provide an evaluation for the top 10 entries in the contest area you have been
          assigned.</li>
          <li>You will want to leave a comment in the contestants comments section of the evalution page for each evaluated manuscript. <strong>Note: The contestants will see these comments in their entirety.</strong>
            <li>You may also want to leave a comment in the committee comments section of the evalution page for each evaluated manuscript. <strong>Note: The committe will see these comments but the contestants will not.</strong>
              <li>There should only be one entry that earns an evaluation of 1 in a particular area.</li>
              <li>You are able to edit your evaluation on any particular entry up to the deadline for judging which is DATE.</li>
              <li>The start the evaluation process please select the
                <a id="ratingsample" class="btn btn-primary btn-xs disabled fa fa-star"> Evaluate</a> button below</li>
              </ul>

              <div class="btn-group" role="group" aria-label="button group">
                <a class="btn btn-warning fa fa-info-circle" href="http://lsa.umich.edu/hopwood/contests-prizes.html" role="button" target="_blank"> Contest Rules</a>
              </div>
            </p>
            <?php
$sqlSelect = <<<SQL
            SELECT
              DISTINCT `tbl_contest`.`id` AS ContestId,
              `tbl_contest`.`date_closed`,
              `tbl_contest`.`judgingOpen`,
              `lk_contests`.`name`,
              `tbl_contestjudge`.`uniqname`
            FROM tbl_contest
            JOIN `lk_contests` ON ((`tbl_contest`.`contestsID` = `lk_contests`.`id`))
            JOIN `tbl_contestjudge` ON (`tbl_contest`.`contestsID` = `tbl_contestjudge`.`contestsID`)
            WHERE `tbl_contest`.`judgingOpen` = 1 AND `tbl_contestjudge`.`uniqname` = '$login_name'
            ORDER BY `tbl_contest`.`date_closed`,`lk_contests`.`name`
SQL;
    if (!$results = $db->query($sqlSelect)) {
        dbFatalError($db->error, " -data insert issue- ", $sqlSelect, $login_name);
        exit($user_err_message);
    } else {
        if ($results->num_rows === 0) {
            $html = "<p class='text-info'>No contests are available for judging</p>";
        } else {
            $html  = '<table class="table table-striped"><tr>';
            $count = $i = 0;
            while ($instance = $results->fetch_assoc()) {
                $count = $i++;
                $html .= '<td><a class="btn btn-primary fa fa-star" href="ranking.php?ctst=' . $instance['ContestId'] . '" role="button"> Evaluate</a>&nbsp;' . $instance['name'] . ' </td>';
                $html .= '</tr><tr>';
            }
            $html .= '</tr></table>';
        }
        echo $html;
    }
    ?>
            <div class="bg-info">
              <p class="text-center">This is the first round of judging using an online system so do not hesite to ask questions or offer comments.
                <ul class="list-inline text-center">
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
        </div>
        <?php include "footer.php";?>
                  <!-- //additional script specific to this page -->
          <script src="js/jdgMyScript.js"></script>
          </div><!-- End Container of all things -->
        </body>
      </html>
        <?php
$db->close();
} else {
    nonDbError(" -ranking submission error- isJudge set to: " . $_SESSION["isJudge"], $login_name);
    ?>
  <!doctype html>

  <html lang="en">
        <head>
          <meta charset="utf-8">

          <title><?php echo $siteTitle; ?></title>
          <meta name="description" content="<?php echo $siteTitle; ?>">
          <meta name="rsmoke" content="LSA_MIS">

          <link rel="shortcut icon" href="ico/favicon.ico">

          <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css">
          <link rel="stylesheet" href="css/bootstrap-theme.min.css" type="text/css">
          <link rel="stylesheet" href="css/bootstrap-formhelpers.min.css" type="text/css">
          <link rel="stylesheet" type="text/css" href="css/myStyles.css">

          <!--[if lt IE 9]>
          <script src="http://html5shiv-printshiv.googlecode.com/svn/trunk/html5.js"></script>
          <![endif]-->
        </head>

        <body>
          <div id="notAdmin">
          <div class="row clearfix">
            <div class="col-xs-8 col-xs-offset-2">
              <div id="instructions" style="color:sienna;">
                <h1 class="text-center" >You are not authorized to this space!!!</h1>
                <h4 class="text-center" >University of Michigan - LSA Computer System Usage Policy</h4>
                <p>This is the University of Michigan information technology environment. You
                  MUST be authorized to use these resources. As an authorized user, by your use
                  of these resources, you have implicitly agreed to abide by the highest
                  standards of responsibility to your colleagues, -- the students, faculty,
                  staff, and external users who share this environment. You are required to
                  comply with ALL University policies, state, and federal laws concerning
                  appropriate use of information technology. Non-compliance is considered a
                  serious breach of community standards and may result in disciplinary and/or
                legal action.</p>
                <div class="text-center">
                  <a href="http://www.umich.edu"><img alt="University of Michigan" src="img/michigan.png" height:280px;width:280px; /> </a>
                </div>
                </div><!-- #instructions -->
              </div>
            </div>
          </div>
        </body>
      </html>
<?php
}
