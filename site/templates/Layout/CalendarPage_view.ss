<main class="typography">

	<% include PageHead %>

	<div class="inner">

		<div id="entry" data-id={$Entry.ID}></div>

		
<!--  		<% if Entry %>
			<% with Entry %>

				<div class="single-entry">

					<div class="content">
						
						$Image

						<h1>$Title</h1>
						<p>$Content</p>

					</div>

					<aside>
						<p>$Created.Format('j F, Y')</p>
						
						<% if Categories %>
							<% loop Categories %>
								<span class="category $URLTitle"></span>
							<% end_loop %>
						<% end_if %>
						
						<a class="button productive" href="{$Top.Link}edit/$ID">Edit entry</a>
					</aside>
					
				</div>

			<% end_with %>
		<% else %>

			<div class="no-results">Could not view entry</div>

		<% end_if %> -->

	</div>
</main>