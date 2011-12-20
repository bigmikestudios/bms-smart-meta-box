<div style="background: #fff">
<textarea name="<?php echo $id?>" id="<?php echo $id?>" rows="20" cols="50"><?php echo $value?></textarea>
</div>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#<?php echo $id?>").addClass("mceEditor");
		if ( typeof( tinyMCE ) == "object" &&
			 typeof( tinyMCE.execCommand ) == "function" ) {
		  tinyMCE.settings = {
			theme : "advanced",
			skin:"wp_theme",
			mode : "none",
			language : "en",
			height:"400",
			width:"100%",
			theme_advanced_layout_manager : "SimpleLayout",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_buttons1 : "bold,italic,strikethrough,|,bullist,numlist,blockquote,|,justifyleft,justifycenter,justifyright,|,link,unlink,wp_more,|,spellchecker,fullscreen,wp_adv",
			theme_advanced_buttons2 : "formatselect,underline,justifyfull,forecolor,|,pastetext,pasteword,removeformat,|,charmap,|,outdent,indent,|,undo,redo,wp_help",
			theme_advanced_buttons3 : "",

			
		  };
		  tinyMCE.execCommand("mceAddControl", true, "<?php echo $id?>");
		}
	});
</script>