$( document ).ready(function(){

  var host = window.location.hostname;
  if (host === "csgrsmoke.lsait.lsa.umich.edu"){
    $('body').prepend("<div class='bg-danger text-center'>THIS IS A DEVELOPMENT ENVIRONMENT -- THIS IS A DEVELOPMENT ENVIRONMENT -- THIS IS A DEVELOPMENT ENVIRONMENT -- THIS IS A DEVELOPMENT ENVIRONMENT </div>");
  }

  $('#contest').on('click', '.btn-eval', function (e){
    var entryid = $(this).data('entryid');
    var panelid = $(this).data('panelid');
    document.location = 'evaluation.php?evid=' + entryid + '&panel=' + panelid;
  });

  $('#contest').on('click', '.btn-contestid', function (e){
    var contestid = $(this).data('contestid');
    document.location = 'ranking.php?ctst=' + contestid;
  });

  var current_page = window.location.pathname.split("/")
  if (current_page[current_page.length-1] == 'evallist.php'){
    $('#collapse'+ window.location.hash.substring(1,2)).addClass('in');
  }
});

