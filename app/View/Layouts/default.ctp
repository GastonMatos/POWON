<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('cake_dev', 'Powon : The Social Network');
?>
<!DOCTYPE html>
<html>
<head>
<script>
function datetime(){
var dt=new Date();
var time= dt.getFullYear()+"/"+((dt.getMonth()+1)<10?"0"+(dt.getMonth()+1):(dt.getMonth()+1))+"/"+dt.getDate()+"/"+"  "+((dt.getHours())<10?"0"+(dt.getHours()):dt.getHours())+":"+((dt.getMinutes())<10?"0"+(dt.getMinutes()):dt.getMinutes())+":"+((dt.getSeconds())<10?"0"+(dt.getSeconds()):dt.getSeconds());
document.getElementById("showtime").innerHTML=time;
t=setTimeout(function(){datetime()},1000);
}
window.onload=function(){
datetime()
}
</script>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('foundation.min');
		echo $this->Html->css('normalize');
		echo $this->Html->css('foundation-datepicker');
		echo $this->Html->css('custom');
		echo $this->Html->css('/foundation-icons/foundation-icons');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
	<nav class="top-bar space" data-topbar>
      <section class="top-bar-section">
	  
        <ul class="left">
          <li>
            <?php
				echo $this->Html->link(
				    $this->Html->image("logo.png", array("alt" => "Powon", 'class' => 'logo')),
				    array(
				        'controller' => 'pages',
				        'action' => 'home',
				        'admin' => false,
				        'plugin' => false
				    ),
				    array(
				    	'escape' => false
				    )
				);
			?>
          </li>
		  <li>


			<li><a id="showtime" class="label"></a></li>
			
			
	  
	
        </ul>
        <ul class="right">
		
			<li class="toggle-topbar menu-icon"><a href="#"><span>Menu</span></a></li>
	        <?php if ($this->Session->read('Auth.User')): ?>

	        	<?php if ($this->Session->read('Auth.User') && $this->Session->read('Auth.User.role') == 'admin'): ?>
	        		<li><?php echo $this->Html->link(
				    'Members',
				    array(
				        'controller' => 'users',
				        'action' => 'index',
				        'admin' => true,
				        'full_base' => true
				    ),
				    array(
					    'escape' => false
					)
				); ?></li>		
	        	
	        	<?php endif ?>	
	        	
				<li><?php echo $this->Html->link(
				    'Announcements',
				    array(
				        'controller' => 'announcements',
				        'action' => 'index',
				        'admin' => false,
				        'full_base' => true
				    ),
				    array(
					    'escape' => false
					)
				); ?></li>
					
			    <?php if ($this->Session->read('Auth.User.status') == 1): ?>    

			        <li class="has-dropdown">
				        <?php echo $this->Html->link(
						    '<i class="fi-torsos large"></i> All Friends',
						     array(
							        'controller' => 'profiles',
							        'action' => 'friends',
							        'admin' => false,
							        'full_base' => true
							    ),
						    array(
							    'escape' => false
							)
						); ?>
				        <ul class="dropdown">
				        	<li><?php echo $this->Html->link(
							    'Friend Requests',
							    array(
							        'controller' => 'profiles',
							        'action' => 'friendRequests',
							        'admin' => false,
							        'full_base' => true
							    ),
							    array(
								    'escape' => false
								)
							); ?></li>
				        	<li><?php echo $this->Html->link(
							    'Friends',
							    array(
							        'controller' => 'profiles',
							        'action' => 'friends',
							        'friend',
							        'admin' => false,
							        'full_base' => true
							    ),
							    array(
								    'escape' => false
								)
							); ?></li>
							<li><?php echo $this->Html->link(
							    'Family',
							    array(
							        'controller' => 'profiles',
							        'action' => 'friends',
							        'family',
							        'admin' => false,
							        'full_base' => true
							    ),
							    array(
								    'escape' => false
								)
							); ?></li>
							<li><?php echo $this->Html->link(
							    'Colleagues',
							    array(
							        'controller' => 'profiles',
							        'action' => 'friends',
							        'colleagues',
							        'admin' => false,
							        'full_base' => true
							    ),
							    array(
								    'escape' => false
								)
							); ?></li>
				        </ul>
				     </li>

			        <li class="has-dropdown">
				        <?php echo $this->Html->link(
						    '<i class="fi-torsos-all large"></i> Groups',
						    '#',
						    array(
							    'escape' => false
							)
						); ?>
				        <ul class="dropdown">
				        	<li><?php echo $this->Html->link(
							    'Group Requests',
							    array(
							        'controller' => 'groups',
							        'action' => 'group_requests',
							        'admin' => false,
							        'full_base' => true
							    ),
							    array(
								    'escape' => false
								)
							); ?></li>
				        	<li><?php echo $this->Html->link(
							    'My Groups',
							    array(
							        'controller' => 'groups',
							        'action' => 'mygroups',
							        'admin' => false,
							        'full_base' => true
							    ),
							    array(
								    'escape' => false
								)
							); ?></li>
				        	<li><?php echo $this->Html->link(
							    'All Groups',
							    array(
							        'controller' => 'groups',
							        'action' => 'index',
							        'admin' => false,
							        'full_base' => true
							    ),
							    array(
								    'escape' => false
								)
							); ?></li>
				        </ul>
				     </li>
					
			        <li><?php echo $this->Html->link(
					    "<i class='fi-mail large'></i> Inbox ",
					    array(
					        'controller' => 'inboxes',
					        'action' => 'view',
					        'admin' => false,
					        'full_base' => true
					    ),
					    array(
						    'escape' => false
						)
					); ?></li>
					
				<?php endif ?>
		        	<li><?php echo $this->Html->link(
					    "<i class='fi-torso large'></i> Welcome, ". $this->Session->read('Auth.User.first_name'),
					    array(
					        'controller' => 'profiles',
					        'action' => 'index',
					        'admin' => false,
					        'full_base' => true
					    ),
					    array(
						    'escape' => false
						)
					); ?></li>
		        	<li><?php echo $this->Html->link(
					    'Logout <i class="fi-power large"></i>',
					    array(
					        'controller' => 'users',
					        'action' => 'logout',
					        'admin' => false,
					        'full_base' => true
					    ),
					    array(
						    'escape' => false
						)
					); ?></li>
	        
			<?php else: ?>
				<li><?php 
	          		echo $this->Html->link(
				    'Sign In <i class="fi-torso large"></i>',
				    array(
				        'controller' => 'users',
				        'action' => 'login',
				        'admin' => false,
				        'full_base' => true
				    ),
				    array(
					    'escape' => false
					)
				);
	           ?></li>
	           <li><?php 
	          		echo $this->Html->link(
				    'Register an account',
				    array(
				        'controller' => 'users',
				        'action' => 'register',
				        'admin' => false,
				        'full_base' => true
				    ),
				    array(
					    'escape' => false
					)
				);
	           ?></li>
			<?php endif; ?>
        </ul>
      </section>
	</nav>


	<div class="row">

		<?php echo $this->Session->flash(); ?>

		<?php echo $this->fetch('content'); ?>
		
	</div>
	<?php echo $this->element('sql_dump'); 
	echo $this->Html->script('vendor/jquery.js');
	echo $this->Html->script('foundation.min');
	echo $this->Html->script('foundation-datepicker');
	echo $this->Html->script('vendor/modernizr');
	echo $this->Html->script('jquery.infinitescroll.min');
	echo $this->Html->script('jquery.validate.min');
	echo $this->Html->script('vendor/jquery.popoutWindow');
	?>
	<script type="text/javascript">
		$(document).foundation();
	</script>
	<script>
		  $(function(){
		    var $container = $('#posts-list');
		 
		    $container.infinitescroll({
		      navSelector  : '.next',    // selector for the paged navigation 
		      nextSelector : '.next a',  // selector for the NEXT link (to page 2)
		      itemSelector : '.post-item',     // selector for all items you'll retrieve
		      debug         : true,
		      dataType      : 'html',
		      loading: {
		          finishedMsg: '',
		          img: '<?php echo $this->webroot; ?>img/spinner.gif'
		        }
		      }
		    );
		  });
		 
	</script>
	<script type="text/javascript">
		$('.fdatepicker').fdatepicker({
        language: 'en',
        format: 'yyyy-mm-dd'
    });
	</script>
</body>
</html>
