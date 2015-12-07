$( document ).ready(function(){
  $('#contest').on('click', '.btn-eval', function (e){
    var entryid = $(this).data('entryid');
    document.location = 'evaluation.php?evid=' + entryid;
  });

  $('#contest').on('click', '.btn-contestid', function (e){
    var contestid = $(this).data('contestid');
    document.location = 'ranking.php?ctst=' + contestid;
  });


});

$(function(){
  $('select[id^=rank_]').change(function()
  {
      // List of ids that are selected in all select elements
      var selected = new Array();

      // Get a list of the ids that are selected
      $('[id^=rank_] option:selected').each(function()
      {
          selected.push($(this).val());
      });

      // Walk through every select option and enable if not 
      // in the list and not already selected
      $('[id^=rank_] option').each(function()
      {
          if (!$(this).is(':selected') && $(this).val() != '')
          {
              var shouldDisable = false;
              for (var i = 0; i < selected.length; i++)
              {
                  if (selected[i] == $(this).val())
                      shouldDisable = true;
              }

              $(this).css('text-decoration', '');
              $(this).removeAttr('disabled', 'disabled');
              if (shouldDisable)
              {
                  $(this).css('text-decoration', 'line-through');
                  $(this).attr('disabled', 'disabled');
              }
          }
      });
  });
});