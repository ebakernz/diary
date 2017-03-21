<main class="typography">

	<% include PageHead %>

	$Content
	$Form

	<section class="table">

		<div class="row heading">
			<div class="col">
				<p>Yeah</p>
			</div>
			<div class="col">
				<p>Nah</p>
			</div>
			<div class="col">
				<p>Maybe?</p>
			</div>
			<div class="col">
				<p>Not in a million years</p>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<p>Minim veniam quis nostrud</p>
			</div>
			<div class="col">
				<p>Nonummy nibh euismod tincidunt ut laoreet</p>
			</div>
			<div class="col">
				<p>Ex ea commodo consequat</p>
			</div>
			<div class="col">
				<p>Consectetuer adipiscing elit</p>
			</div>
		</div>

		<div class="row">
			<div class="col">
				<p>Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
			</div>
			<div class="col">
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Nisl ut aliquip ex ea commodo consequat.</p>
			</div>
			<div class="col">
				<p>Lorem ipsum dolor sit amet, consectetuer. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat.</p>
			</div>
			<div class="col">
				<p>Consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam.</p>
			</div>
		</div>

	</section>

</main>

<aside class="typography">

	<h2>Side bar</h2>

	<nav>
		<% loop Menu(1) %>
			<a href="{$Link}">{$MenuTitle.XML}</a>
		<% end_loop %>
	</nav>

</aside>