<script>
    function loadTabsContents( version_id ){
        var element_type_id = '<?php echo $element_type_id ?>';
        var event_id = '<?php echo $event_id ?>';
		var options = {
			id: 'previous-modifications-dialog',
			title: 'Previous modifications'
		}    	
	    $.ajax({
			type: 'GET',
            cache: false,
			url: baseUrl + '../DisplayPreviousModifications',
			processData : false,
			data: "version_id="+version_id+"&event_id="+event_id+"&element_type_id="+element_type_id,
			'success': function(html) {
			    $('#tabs-'+version_id).html(html);
	        }
	    });
    }
        
    $( function() {
        $( "#historyTabs" ).tabs();
        
    } );

</script>


<?php
   $versions = $element -> getPreviousUsersFromEventIdByVersions($event_id);
?>

<div id="historyTabs">
  <ul>
    <?php foreach($versions as $key => $oneVersion) { ?>
        <li><a href="#tabs-<?php echo $oneVersion['version_id']; ?>"><?php echo $oneVersion['first_name'].' '.$oneVersion['last_name'].' '.$oneVersion['last_modified_date']  ?></a></li>
    <?php } ?>
  </ul>
  <?php foreach($versions as $key => $oneVersion) { 
    $element -> event -> fromVersion();
    //$element -> event -> getPreviousVersions();
  ?>
      <div id="tabs-<?php echo $oneVersion['version_id']; ?>">
            
            <script>
                loadTabsContents("<?php echo $oneVersion['version_id']; ?>");
            </script>
      </div>
  <?php } ?>

</div>