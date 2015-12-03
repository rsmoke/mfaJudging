/*
  this code is part of a 3 part validator setup. It works with all modern browsers and is 
  an excellent fix for the Safari browser non-compliance to the 'required' attribute.

  The Parts:
    1) HTML form tag must have a class="validate-form" and should have a message area
        with id="status"
    2) CSS each type of form element has a two part definition
        .invalid input:required:invalid
        .invalid input:required:valid
    3) JS controls the class updating to show if the form fild is valid or invalid

    source:A PEN BY Ash Blue http://codepen.io/ashblue/pen/KyvmA;
*/

function hasHtml5Validation () {
  return typeof document.createElement('input').checkValidity === 'function';
}

if (hasHtml5Validation()) {
  $('.validate-form').submit(function (e) {
    if (!this.checkValidity()) {
      e.preventDefault();
      $(this).addClass('invalid');
      $('#status').html('invalid');
    } else {
      $(this).removeClass('invalid');
      $('#status').html('submitted');
    }
  });
}