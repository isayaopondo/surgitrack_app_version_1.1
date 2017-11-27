<div id="main" role="main">

			<!-- MAIN CONTENT -->

			<form class="lockscreen animated flipInY" action="index.html">
				<div class="logo">
					<h1 class="semi-bold"><img src="<?= base_url() ?>assets/img/logo-o.png" alt="" /> SurgiTrack</h1>
				</div>
				<div>
					<img src="<?= isset($_SESSION["profilephoto"]) ? $_SESSION["profilephoto"] : base_url('assets/img/avatars/sunny-big.png') ?>" alt="" width="120" height="120" />
					<div>
						<h1><i class="fa fa-user fa-3x text-muted air air-top-right hidden-mobile"></i><?= $_SESSION["fullname"] ?> <small><i class="fa fa-lock text-muted"></i> &nbsp;Locked</small></h1>
						<p class="text-muted">
							<a href="mailto:simmons@smartadmin">john.doe@surgitrack.com</a>
						</p>

						<div class="input-group">
							<input class="form-control" type="password" placeholder="Password">
							<div class="input-group-btn">
								<button class="btn btn-primary" type="submit">
									<i class="fa fa-key"></i>
								</button>
							</div>
						</div>
						<p class="no-margin margin-top-5">
							Logged as someone else? <a href="login.html"> Click here</a>
						</p>
					</div>

				</div>
				<p class="font-xs margin-top-5">
					Copyright SurgiTrack 2014-2020.

				</p>
			</form>

		</div>