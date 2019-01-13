<nav class="navbar navbar-expand-lg navbar-light bg-light">
	<a class="navbar-brand px-3" href="/">
        <img src="/img/logo.png" height="45" class="d-inline-block align-top" alt="logo" id="logo">
	</a>

	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto"></ul>
		<div class="my-2 my-lg-0 px-5 item6">
    		<div class="nav-item dropdown">
    		<a class="nav-link dropdown-toggle mr-sm-2" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    		<img src="/img/user.png" width="35" height="35" class="d-inline-block userimg">
    		</a>
    	    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                <a class="dropdown-item" onclick="getUserPSPData(0)">My PSP</a>
    			<a class="dropdown-item" href="/logout">Logout</a>
    		</div>
    		</div>
		</div>
	</div>
</nav>