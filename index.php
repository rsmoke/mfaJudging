<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishMFAJudging.php';
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
    <title>LSA-<?php echo "$contestTitle"; ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="LSA-English Writing Contests">
    <meta name="keywords" content="LSA-English, MFA, Writing, UniversityofMichigan">
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
          <button type="button" class="navbar-toggle" data-toggle="collapse"
          data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">
            Toggle navigation</span><span class="icon-bar"></span><span
            class="icon-bar"></span><span class="icon-bar"></span></button>
            <a class="navbar-brand" href="index.php"><?php echo "$contestTitle"; ?>
              <span style="color:#00FF80"> - Judging</span></a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    Signed in as <?php echo $login_name; ?><strong class="caret">
                  </strong></a>
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
          <div class="bg-warning text-center" style="height: 3rem;">
            <h5>Upon completion of your evaluations, please email the MFA Contest Office <a href="mailto:mfacontestnotify@umich.edu">(mfacontestnotify@umich.edu)</a> the <u>Contest name</u> and <u>Title</u> of the winning entry</h5>
          </div>
          <hr>
          <p>
          To assist you with choosing the winning entry we have provided an optional rating system.
            <ul>
              <li>You may give the entry a value of 1 up to 10 with <strong>1</strong> considered the best or highest. </li>
              <li>The comment areas are also optional and for your own use. No one will read the comments.</li>
              <li>You are able to edit your evaluation on any particular entry up to the deadline for judging.</li>
              <li>To start the evaluation process please select the Evaluate button below</li>
            </ul>
                  <p><a href='mailComment.php'><span class="glyphicon glyphicon-question-sign" aria-hidden="true"></span> Questions or Comments</a></p>
                  <div class="clearfix text-center">
                    <div  role="group" aria-label="button group">
                      <a class="btn btn-lg btn-primary fa fa-sort-numeric-asc" href="evallist.php" role="button"> Evaluate</a>
                    </div>
                  </div>
                </p>
                <div class="bg-info">
                    <ul class="list-inline text-center">
                      <li>
                        <address>
                          <strong>MFA Contest</strong><br>
                          <abbr title="eMail">e:</abbr>
                          <a href="mailto:mfacontestnotify@umich.edu">mfacontestnotify@umich.edu</a>
                        </address>
                      </li>
                    </ul>
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
        <title><?php echo $contestTitle; ?></title>
        <meta name="description" content="<?php echo $contestTitle; ?>">
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
