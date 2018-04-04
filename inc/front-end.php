
<?php
$url = "http://www.nytimes.com/";
$image = $pgnyt_results->{'response'}->{'docs'}[0]->{'multimedia'}[1]->{'url'};?>		

<div class="pgnyt-articles frontend">
	<p style="margin-left:40px"><?php echo $title ?></p>
	<ul class="pgnyt-articles" style="list-style-type: none;">
		
		<?php for( $i = 0; $i < $num_articles; $i++ ):?>
			
				<ul>
					
					
 <?php
	 if ($display_image == 1):
	 
 if( count($pgnyt_results->{'response'}->{'docs'}[$i]->{'multimedia'}) > 0):
 ?>					
<li style="list-style-type: none;">
<img width="200px" src = "<?php echo $url . $pgnyt_results->{'response'}->{'docs'}[$i]->{'multimedia'}[1]->{'url'}; ?>"></img>
</li>	
			
<?php  endif; ?>
<?php  endif; ?>				
					<li class="pgnyt-articles-name" style="list-style-type: none; background-color: red;">
					<a href="<?php echo $pgnyt_results->{'response'}->{'docs'}[$i]->{'web_url'}; ?>
"><?php echo $pgnyt_results->{'response'}->{'docs'}[0]->{'headline'}->{'main'}; ?></a>
					</li>
					
					<li class="pgnyt-articles-paragraph" style="list-style-type: none;">
					<p> <?php echo $pgnyt_results->{'response'}->{'docs'}[$i]->{'snippet'}?> </p>
					</li>
				</ul>
			
			<?php endfor; ?>
		</ul>
					
		</div>