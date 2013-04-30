			<div id="footer">
				<div id="little">
				</div>
				<div id="siteinfo">
					&copy; 2013. Sukasukague.<br />
					Enjella.Danny.Arya
				</div>
				<div id="botlink">
					<ul>
						<li><a href="dashboard.php">DASHBOARD</a></li>
						<li><a href="profil.php">PROFIL</a></li>
						<li><a href="logout.php">LOGOUT</a></li>
					</ul>
				</div>
			</div>
		</div>
		<?php
		if (strcmp($uri,"rinciantugas.php") == 0) {
			echo '<script type="text/javascript" src="rinciantugas.js"></script>';
		} else if (strcmp($uri,"post.php") == 0) {
			echo '<script type="text/javascript" src="post.js"></script>';
		}
		?>
	</body>
</html>
<?php // mysqli_close($con);?>