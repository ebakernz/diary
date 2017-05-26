<aside class="sidebar">
	
	<a class="logo" href="/">
		$SiteConfig.Logo
		<span class="fa fa-book"></span>
		<p>$SiteConfig.Title</p>
	</a>

	<nav class="cf">

		<a href="/entries/new" class="new">
			<span class="icon"></span>
			New entry
		</a>

		<% loop Menu(1) %>
			<a href="{$Link}" class="$LinkingMode $URLTitle">
				<span class="icon"></span>
				{$MenuTitle.XML}
			</a>
		<% end_loop %>
	</nav>

</aside>