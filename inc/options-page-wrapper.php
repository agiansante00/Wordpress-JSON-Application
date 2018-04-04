


<div class="wrap">

	<div id="icon-options-general" class="icon32"></div>
	<h1>NYT ARTICLE</h1>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
		
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">
	
				
<!-- DISPLAY IF STATEMENT -->	
				
<?php if (!isset($pgnyt_search) || $pgnyt_search == "" ): ?>
					
					<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->




<!--MAIN CONTAINER-->
<h2 class="hndle"><span>BOX1</span></h2>
<div class="inside">

<!--FORM -->
<form method="post">

<!-- HIDDEN INPUT -->
<input type="hidden" name="pgnyt_form_submitted" value="Y">


<table class="form-table">
<tr valign="top">

<!--ARTICLE SEARCH SEARCH -->		
	<td scope="row"><label for="tablecell"></label>Search:</td>
	<td><input type="text" value="" name="pgnyt_search" id="pgnyt_search" class="regular-text"></td>
	</tr>
	
<!--API SEARCH -->
	<tr valign="top" class="alternate">
	<td scope="row"><label for="tablecell"></label>API:</td>
		<td>
		<input type="text" value="" name="pgnyt_apikey" id="pgnyt_apikey" class="regular-text">
		</td>
	</tr>
	
<!--BUTTON -->
	<tr valign="top">
	<td scope="row"><label for="tablecell"></label>
	<input class="button-primary" type="submit" name="pgnyt_form_sumbit" id="pgnyt_form_submit" value="SAVE">
	</td>
	<td></td>
	</tr>
	
</table>
</form>


<?php endif; ?>




				</div>
						<!-- .inside -->
<?php if (isset($pgnyt_search)): ?>
<!--
ARTICLE DISPLAY
-->
<?php
$url = "http://www.nytimes.com/";
$image = $pgnyt_results->{'response'}->{'docs'}[0]->{'multimedia'}[1]->{'url'};?>		

<div class="inside-articles">
	<p>CONTENT</p>
<ul class="pgnyt-articles">
		
		<?php for( $i = 0; $i < 12; $i++ ):?>
			<li>
				<ul>
					
					
 <?php
 if( count($pgnyt_results->{'response'}->{'docs'}[$i]->{'multimedia'}) > 0):
 ?>					
<li>
<img width="200px" src = "<?php echo $url . $pgnyt_results->{'response'}->{'docs'}[$i]->{'multimedia'}[1]->{'url'}; ?>"></img>
</li>	
			
<?php  endif; ?>				
					<li class="pgnyt-articles-name">
					<a href="<?php echo $pgnyt_results->{'response'}->{'docs'}[$i]->{'web_url'}; ?>
"><?php echo $pgnyt_results->{'response'}->{'docs'}[0]->{'headline'}->{'main'}; ?></a>
					</li>
					
					<li class="pgnyt-articles-paragraph">
					<p> <?php echo $pgnyt_results->{'response'}->{'docs'}[$i]->{'snippet'}?> </p>
					</li>
				</ul>
			</li>
			<?php endfor; ?>
		</ul>
					
		</div>
		
<!-- .postbox -->
<div class="postbox">
<div class="handlediv" title="Click to toggle"><br></div>
<!-- Toggle -->
<h2 class="hndle"><span>JSON PARSED DATA</span></h2>
<div class="inside">
	<p>
	<?php echo $pgnyt_results->{'response'}->{'docs'}[0]->{'web_url'}; ?>
	</p>
	<p>
		<?php echo $pgnyt_results->{'response'}->{'docs'}[0]->{'headline'}->{'main'}; ?>
	</p>
	<p>
		<?php echo $pgnyt_results->{'response'}->{'docs'}[0]->{'snippet'}?>
	</p>
	
<p><?php echo $pgnyt_results->{'response'}->{'docs'}[0]->{'multimedia'}[1]->{'url'};?></p>
<p>
 <img src = "<?php echo $url . $image; ?>"></img>
</p>


<!-- <pre><code><?php var_dump($pgnyt_results); ?></code></pre>  -->
	
</div>
<!-- .inside -->
</div>
</div>


<!-- .postbox -->
<?php endif; ?>	
				</div>
				


					<!-- .postbox -->
					
					
				</div>
			</div>








			<!-- sidebar -->
			
<!--
			
BOX2
-->			
			
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">


						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->

						<h2 class="hndle"><span>SEARCH</span></h2>

						<div class="inside">
<form method="post">
<input type="hidden" name="pgnyt_form_submitted" value="Y">
<p>	
<input type="text"  name="pgnyt_search" id="pgnyt_search" size="25" placeholder="<?php echo $pgnyt_search ?>">
</p>
<p>
<input type="text" name="pgnyt_apikey" id="pgnyt_apikey"  size="25" placeholder="<?php echo $pgnyt_apikey ?>">
</p> 
<p>
<input class="button-primary" type="submit" name="pgnyt_form_sumbit" id="pgnyt_form_submit" value="UPDATE">
</p>

</form>
						</div>
						<!-- .inside -->

					</div>

<!-- .meta-box-sortables -->



			</div>
			<!-- #postbox-container-1 .postbox-container -->

		</div>
		<!-- #post-body .metabox-holder .columns-2 -->
		
		
		
		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->


		
		
	


