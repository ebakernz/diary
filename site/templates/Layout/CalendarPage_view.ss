<main class="typography">

	<% include PageHead %>

	<div class="inner">
		<% if Entry %>

			

			<% with Entry %>
				<div class="single-entry">

					<div class="content">
						
						$Image

						<h1>$Title</h1>
						<p>$Content</p>

					</div>

					<aside>
						<p>$Created.Format('j F, Y')</p>
						<a class="button productive" href="/edit">Edit entry</a>
					</aside>
					
				</div>
			<% end_with %>

		<% else %>
			<div class="no-results">Could not view entry</div>
		<% end_if %>

	</div>
</main>