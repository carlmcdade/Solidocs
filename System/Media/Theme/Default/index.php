<?php $this->theme_part('header');?>
		
	<div id="content">
		
		<?php $this->render_content();?>
		
		<div id="footer">
		
			<?php echo microtime_since(STARTTIME);?>s | <?php echo round(memory_get_peak_usage() / 1024 / 1024, 4);?> MB
			
		</div>
		
	</div>

<?php $this->theme_part('footer');?>