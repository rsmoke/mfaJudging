<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContestJudging.php');
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/basicLib.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// $isJudge = false;
// $_SESSION["isJudge"] = 0;

// $sql = <<< _SQL
//   SELECT *
//   FROM tbl_contestjudge
//   WHERE uniqname = '$login_name'
//   ORDER BY uniqname
// _SQL;

// if (!$resJudge = $db->query($sql)) {
//         db_fatal_error("data read issue", $db->error);
//         exit;
// }

// if ($resJudge->num_rows > 0) {
//     $isJudge = true;
//     $_SESSION["isJudge"] = 1;
// }

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
  <base href=$URLS>
</head>

<body>
        <nav class="navbar navbar-default navbar-fixed-top navbar-inverse" role="navigation">
          <div class="container">
          <div class="navbar-header">
             <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1"> <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button> <a class="navbar-brand" href="index.php"><?php echo "$contestTitle";?><span style="color:#00FF80"> - Judging</span></a>
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

    <?php if ($_SESSION["isJudge"]) {
        ?>
  <div class="container"><!-- container of all things -->

<div id="contest">
  <div class="row clearfix">
    <div class="bg-warning infosection">
    <p><strong>Evaluting instructions: </strong> Select an entry that you want to evaluate and click the star button next to it to go to the ranking form for that entry. </p>
    <a class="btn btn-xs btn-warning fa fa-info-circle" href="http://lsa.umich.edu/hopwood/contests-prizes.html" target="_blank"> Contest Rules</a>
    </div>
  </div>
  <div class="row clearfix">
    <div class="col-md-12">

    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

<?php
$sqlContestSelect = <<<SQL
SELECT
        DISTINCT `tbl_contest`.`id` AS ContestId,
        `tbl_contest`.`date_closed`,
        `tbl_contest`.`judgingOpen`,
        `lk_contests`.`name`,
        `lk_contests`.`freshmanEligible`,
        `lk_contests`.`sophmoreEligible`,
        `lk_contests`.`juniorEligible`,
        `lk_contests`.`seniorEligible`,
        `lk_contests`.`graduateEligible`,
        `tbl_contestjudge`.`uniqname`
    FROM tbl_contest
    JOIN `lk_contests` ON ((`tbl_contest`.`contestsID` = `lk_contests`.`id`))
    JOIN `tbl_contestjudge` ON (`tbl_contest`.`contestsID` = `tbl_contestjudge`.`contestsID`)
    WHERE `tbl_contest`.`judgingOpen` = 1 AND `tbl_contestjudge`.`uniqname` = '$login_name'
    ORDER BY `tbl_contest`.`date_closed`,`lk_contests`.`name`
SQL;

$results = $db->query($sqlContestSelect);
if (!$results) {
    echo "There is no contest information available";
} else {
    $count = $i = 0;
    while ($instance = $results->fetch_assoc()) {
        $count = $i++;
?>
      <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="heading<?php echo $count ?>">
          <h6 class="panel-title">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $count ?>" aria-expanded="false" aria-controls="collapse<?php echo $count ?>">
                <?php echo $instance['name'] . " <br /><small>closed: </small><span style='color:#0080FF'>" . date_format(date_create($instance['date_closed']),"F jS Y \a\\t g:ia") . "</span>" ?>
            </a>
          </h6>
        </div>
        <div id="collapse<?php echo $count ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $count ?>">
          <div class="panel-body">
             <div class="table-responsive">
              <table class="table table-hover table-condensed">
                <thead>
                <tr>
                  <th>Rate</th><th>Title</th><th>Manuscript<br><em>(opens in a new browser tab)</em></th><th>Authors<br>Pen-name</small></th><th>Manuscript Type</th><th><small>AppID</small></th>
                  </tr>
                </thead>
                <tbody>
<?php
if ($instance['ContestId'] < 18){
$sqlIndEntry = <<<SQL
   SELECT *
   FROM vw_entrydetail
   LEFT OUTER JOIN tbl_evaluations ON (vw_entrydetail.`EntryId`= `tbl_evaluations`.`entry_id` AND `tbl_evaluations`.evaluator = '$login_name')
    WHERE ContestInstance = {$instance['ContestId']} AND manuscriptType IN (
      SELECT DISTINCT name
      FROM `lk_category`
      JOIN `tbl_contestjudge` ON (`tbl_contestjudge`.`categoryID` = `lk_category`.`id`)
      WHERE uniqname = '$login_name') AND vw_entrydetail.status = 0
      ORDER BY manuscriptType
SQL;
}else{
$sqlIndEntry = <<<SQL
     SELECT *
   FROM vw_entrydetail_with_classlevel AS vw
   LEFT OUTER JOIN tbl_evaluations ON (vw.`EntryId`= `tbl_evaluations`.`entry_id` AND `tbl_evaluations`.evaluator = '$login_name')
    WHERE vw.ContestInstance = {$instance['ContestId']} AND vw.manuscriptType IN (
      SELECT DISTINCT name
      FROM `lk_category`
      JOIN `tbl_contestjudge` AS CJ ON (CJ.`categoryID` = `lk_category`.`id`)
      WHERE uniqname = '$login_name') AND vw.status = 0 AND ((CASE WHEN vw.`classLevel` < 20 THEN 1 WHEN  vw.`classLevel` = 20 THEN 2 END) = (Select CJ2.classLevel FROM `tbl_contestjudge` AS CJ2 WHERE CJ2.uniqname = '$login_name' AND CJ2.`contestsID` = (SELECT contestsID FROM tbl_contest WHERE tbl_contest.id = {$instance['ContestId']})) OR 0 = (Select CJ2.classLevel FROM `tbl_contestjudge` AS CJ2 WHERE CJ2.uniqname = '$login_name' AND CJ2.`contestsID` = (SELECT contestsID FROM tbl_contest WHERE tbl_contest.id = {$instance['ContestId']})))
SQL;
}
$resultsInd = $db->query($sqlIndEntry);
if (!$resultsInd) {
    echo "<tr><td>There are no applicants available</td></tr>";
} else {
    while ($entry = $resultsInd->fetch_assoc()) {
      echo '<tr><td><button class="btn btn-sm btn-info btn-eval fa fa-sort-numeric-asc btn btn-success" data-entryid="' . $entry['EntryId'] . '"></button></td><td>' . $entry['title'] . '</td><td><a href="contestfiles/' . $entry['document'] . '" target="_blank"><span class="fa fa-book fa-lg"></span></a></td><td>' . $entry['penName'] . '</td><td>' . $entry['manuscriptType'] . '</td><td><small>' . $entry['EntryId'] . '</small></td></tr>';
    }
}

?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
<?php
    }
}
?>
    </div>
    </div>
  </div>
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
      <script type="text/javascript">
        $('.disabled').toggleClass("btn-info");
      </script>
</div><!-- End Container of all things -->
</body>
</html>

<?php
  $db->close();
