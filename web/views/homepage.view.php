<?php
include_once('student.view.php');
	
class HomepageView {
	
	static function getHomepageHtml() {
		$studentHtml = StudentView::getHomepageStudentHtml();
		return <<<HTML
			
			<div id="root">
				<h1 class="center">UNHM CompTech Internship Manager</h1>
				<div id="st-accordion1" class="st-accordion">
					<h2>Position Management</h2>
					<ul>
						<li>
							<a href="#">
								<img src="./library/images/icons/file plus.png" /> Create New Position <span class="st-arrow">Open or Close</span>
							</a>
							<div class="st-content">
								<!--Create New Position content-->
								Create New Position content...
							</div>
						</li>
						<li>
							<a href="#">
								<img src="./library/images/icons/user.png" /> Search Positions <span class="st-arrow">Open or Close</span>
							</a>
							<div class="st-content">
								<!--Search Positions content-->
								Search Positions content...
							</div>
						</li>
					</ul>
				</div>

				<div id="st-accordion2" class="st-accordion">
					<h2>Database Management</h2>
					<ul>
						<li>
							<a href="#">
								<img src="./library/images/icons/user.png" /> Students <span class="st-arrow">Open or Close</span>
							</a>
							<div class="st-content">
								<!--student content-->
								$studentHtml
							</div>
						</li>
						<li>
							<a href="#">
								<img src="./library/images/icons/user.png" /> Companies <span class="st-arrow">Open or Close</span>
							</a>
							<div class="st-content">
								<!--student content-->
								Company content...
							</div>
						</li>
						<li>
							<a href="#">
								<img src="./library/images/icons/user.png" /> Supervisors <span class="st-arrow">Open or Close</span>
							</a>
							<div class="st-content">
								<!--student content-->
								Supervisor content...
							</div>
						</li>
					</ul>
				</div>
				<script type="text/javascript">
		            $(function() {
						$('#st-accordion1').accordion();
						$('#st-accordion2').accordion();
		            });
		        </script>
		    </div>
HTML;
	}
}
	
?>