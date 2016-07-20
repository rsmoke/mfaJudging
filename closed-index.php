<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '/../Support/configEnglishContestJudging.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>LSA-<?php echo "$contestTitle";?> Writing Contests Opens Soon!</title>

  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="LSA-English Writing Contests">
  <meta name="keywords" content="LSA-English, Hopwood, Writing, UniversityofMichigan">
  <meta name="author" content="LSA-MIS_rsmoke">
  <link rel="icon" href="img/favicon.ico">
  <style type="text/css">
    html {
      background: url(img/evaluateImage.jpg) no-repeat center center fixed;
      -webkit-background-size: cover;
      -moz-background-size: cover;
      -o-background-size: cover;
      background-size: cover;
      filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='img/evaluateImage.jpg', sizingMethod='scale');
      -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='img/evaluateImage.jpg', sizingMethod='scale')";
    }

    .text-center {
        color: black;
        font-weight: bold;
        text-align: center;
    }

    footer {
      position: fixed;
      bottom: 100px;
      width: 130%;
    }

    h2 {
      text-shadow: 0px 1px 0px rgb(204, 204, 204), 0px 2px 0px rgb(201, 201, 201), 0px 3px 0px rgb(187, 187, 187), 0px 4px 0px rgb(185, 185, 185), 0px 5px 0px rgb(170, 170, 170), 0px 6px 1px rgba(0, 0, 0, 0.1), 0px 0px 5px rgba(0, 0, 0, 0.1), 0px 1px 3px rgba(0, 0, 0, 0.3), 0px 3px 5px rgba(0, 0, 0, 0.2), 0px 5px 10px rgba(0, 0, 0, 0.25), 0px 20px 20px rgba(0, 0, 0, 0.15);
      color: #0000FF;
      font-family: 'League Gothic', Impact, sans-serif;
      line-height: 1.2em;
      letter-spacing: 0.03em;
      text-transform: uppercase;
      margin: 1em auto;
      text-align: center;
      font-size: 1.2rem;

    }

    #copyright {
      padding-top:10px;
      margin-left: -8px;
      background-color: #CCCCCC;
      position: fixed;
      bottom: 0px;
      width: 100%;
    }
  </style>
</head>

<body>

  <div>
    <h1 class="text-center">The Judging section of the Hopwood writing contests is currently not available.<br>Please
    check back.</h1>
  </div>
<footer>
  <div class="text-center" >
    <address>
      <h2>Department of <?php echo $deptLngName;?></h2>
      <a href="mailto:<?php echo strtolower($addressEmail);?>"><?php echo strtolower($addressEmail);?></a><br>
      <br><?php echo $addressBldg;?>, <?php echo $address2;?>
      <br><?php echo $addressStreet;?>
      <br>Ann Arbor, MI
      <br><?php echo $addressZip;?>
      <br>P: <?php echo $addressPhone;?>
      <br>F: <?php echo $addressFax;?>
    </address>

  </div>
</footer>
  <div id="copyright" class="text-center">
  <img class="img" src="img/lsa.png" alt="LSA at the University of Michigan"><br>
    <a href="http://www.regents.umich.edu">© 2014 Regents of the University of Michigan</a>
  </div>

</body>
