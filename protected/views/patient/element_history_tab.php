<style>
#historyTabs { 
    padding: 0px; 
    background: none; 
    border-width: 0px; 
} 
#historyTabs .ui-tabs-nav { 
    padding-left: 0px; 
    background: transparent; 
    border-width: 0px 0px 1px 0px; 
    -moz-border-radius: 0px; 
    -webkit-border-radius: 0px; 
    border-radius: 0px; 
} 
#historyTabs .ui-tabs-panel { 
    border-width: 0px 1px 1px 1px; 
}

#historyTabs .ui-tabs-anchor{
    font-size: 8pt;    
    
} 

#historyTabs .ui-tabs-nav li.ui-tabs-selected, 
#historyTabs .ui-tabs-nav li.ui-state-active {
    font-size: 8pt;    
    font-weight: bold;
}

</style>

<script>
    function fixSpans(_html){
        var pattern = /\|span.*class=\[(.+?)\].*\|(.*)\|span\|/g;
        _html = _html.replace(pattern, '<span class="$1">$2</span>');

        return _html;
    }
    
    function loadTabsContents( version_id ){
        var element_type_id = '<?php echo $element_type_id ?>';
        var event_id = '<?php echo $event_id ?>';
		var options = {
			id: 'previous-modifications-dialog',
			title: 'Previous versions'
		}    	
	    $.ajax({
			type: 'GET',
            cache: false,
			url: baseUrl + '../DisplayPreviousModifications',
			processData : false,
			data: "version_id="+version_id+"&event_id="+event_id+"&element_type_id="+element_type_id,
			'success': function(_html) {
			    $('#tabs-'+version_id).html(fixSpans(_html));
	        }
	    });
    }
        
    $( function() {
        $( "#historyTabs" ).tabs();
        
    } );

</script>


<?php
    $versions = $element -> getPreviousModificationsHeader($event_id);
    $versionCount = count($versions);
        
    for($i=1; $i < $versionCount;$i++){
        echo ($i-1).'-'.$i.'  ';
        $version1 = $element -> getVersion($versions[$i-1]['version_id']);
        $version2 = $element -> getVersion($versions[$i]['version_id']);
        
        $hasDiff = $element -> hasDiffVersions($version1,$version2);
        if($hasDiff){
            
            $diffVersions[$versions[$i-1]['version_id']] = $version1;
            $diffVersions[$versions[$i]['version_id']] = $version2;
        } 
        
    }
?>

<div id="historyTabs">
  <ul>
    <?php foreach($diffVersions as $version_id => $oneVersion) { ?>
        <li><a href="#tabs-<?php echo $version_id; ?>"><?php echo $oneVersion->last_modified_date; ?></a></li>
    <?php }  ?>
  </ul>
  
  <?php foreach($diffVersions as $version_id => $oneVersion) { ?>
    <div id="tabs-<?php echo $version_id; ?>">
        <script>
            loadTabsContents("<?php echo $version_id; ?>");
        </script>
    </div>
  <?php }  ?>
</div>