$('#get-num-submit').on('click', function () {
   $('div#data').load('/Home/number', {

   })
});

   $('#update-row-submit').on('click', function()
   {
      var desc = $('textarea#tabletext').val().replace(/ /g, '.!.');
      var title = $('input#tabletext').val().replace(/ /g, '.!.');
      var id = $('p#id').text();

      $('#upd').load('/Gallery/update/' + title +'/' + desc + '/' + id + '', alert('Updated'))

   });