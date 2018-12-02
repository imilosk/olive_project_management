@php
    global $auth;
@endphp


	<nav class="navbar navbar-expand-lg navbar-light bg-light">
  		<a class="navbar-brand" href="#"><span class="lead">Olive</span><br><span>Project Managment</span></a>
  
  		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    		<span class="navbar-toggler-icon"></span>
    	</button>

    	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    		<ul class="navbar-nav mr-auto">
      			<li class="nav-item active">
        			<a class="nav-link" href="/">Home <span class="sr-only">(current)</span></a>
				  </li>
				  @if ($auth->isLoggedIn())
      			<li class="nav-item border border-right-0 px-2">
        			<a class="nav-link" href="/timeNotes">Time</a>
      			</li>
     			<li class="nav-item border px-2">
        			<a class="nav-link" href="/Mistakes">List</a>
      			</li>
      			<li class="nav-item border border-left-0 px-2">
        			<a class="nav-link" href="/Mistakes">Board</a>
      			</li>
				<li class="nav-item border border-left-0 px-2">
        			<a class="nav-link" href="/projects">All projects on OLIVE</a>
      			</li>
			</ul>
  		</div>


		<div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item">
					<a class="nav-link" href="/logout">Logout</a>
				</li>
				<li class="nav-item border border-left-0 px-2">
				{{ @$auth->getEmail() }}
				</li>
				
			</ul>
		</div>
	</nav>
@else
	<a href="/register">Register</a>
	<a href="/login">Login</a>
	<hr/>
@endif

