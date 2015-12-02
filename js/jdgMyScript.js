$( document ).ready(function(){
  $('#contest').on('click', '.btn-eval', function (e){
    var entryid = $(this).data('entryid');
    document.location = 'evaluation.php?evid=' + entryid;
  });
});