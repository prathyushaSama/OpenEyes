$(document).ready(function () {

  function errorTranscript($transcript) {
    $transcript.addClass('error');
  }

  function validateGeneTranscript() {
    var $transcript = $(this);
    $.getJSON('https://192.168.111.222/json/checkSyntax', {variant: $transcript.val()}, function(data){
      if(data.valid){
        $transcript.removeClass('error');
      } else {
        errorTranscript($transcript);
      }
    }).fail(function() {
      errorTranscript($transcript);
    });
  }

  var $pedigreeGeneTranscript = $('#Pedigree_gene_transcript');
  $pedigreeGeneTranscript.on('change', validateGeneTranscript);
  $pedigreeGeneTranscript.trigger('change');
});