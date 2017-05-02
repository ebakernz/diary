<main class="typography">
	
	<% include PageHead %>

	<div class="inner">	

		<% if Entry %>
			<% with Entry %>

				<div class="entry-edit">

					<h1>Edit entry</h1>
					$Up.Form

				</div>

			<% end_with %>
		<% else %>
			<div class="no-results">Could not edit entry</div>
		<% end_if %>

	</div>
	
</main>