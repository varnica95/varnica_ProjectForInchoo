$('#get-num-submit').on('click', function () {
   $('div#data').load('/home/number', {

   })
});

   $('#update-row-submit').on('click', function()
   {
      var desc = $('textarea#tabletext').val().replace(/ /g, '.!.');
      var title = $('input#tabletext').val().replace(/ /g, '.!.');
      var id = $('p#id').text();

      if (desc !== '' && title !== '')
          $('#upd').load('/gallery/update/' + title +'/' + desc + '/' + id + '', alert('Updated'));
      else
          alert('Empty fields. Can not update the table.');


   });