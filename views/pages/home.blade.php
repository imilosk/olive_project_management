@extends('../body') 

@php
    global $auth;
@endphp

<!-- DEJ KODO NAZAJ SEM -->
@if (!$auth->isLoggedIn())
@php 
	header('Location: /login'); 
	exit();
@endphp
@endif

@section('content')
	
	<header class="header-wrapper">
        @include('includes/navbar')
    </header>

    <div id="wrapper">
    	
		<div id="btn-openSideMenu"></div>

		<div id="sideMenu" class="modal">
			<div class="modal-content">

				<div class="modal-header">
					<h2>Organisations</h2>
			    	<span class="close">&times;</span>
			  	</div>

			  	<div class="modal-body">
			    	<div id="modal-body_organistaions">
			    	</div>
			  	</div>

			  	<div class="modal" id="addOrganisationModal">
			  		<div id="addOrganisationModal_header"></div>
				  	<input type="text" id="addOrganisation-name" name="name" placeholder="Name">
				  	<input type="text" id="addOrganisation-description" placeholder="Description">
				  	<div id="btn-addNewOrganisation">Create</div>
			  	</div>
			  	<div class="modal-footer">
			  		<div id="btn-openOrganisationModal">Add Organisation</div>
			  	</div>
			</div>
		</div>

		<div id="test">@php echo $auth->getUserId(); @endphp</div>

		Danes je vreme deževno

	</div>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/handlebars-v4.0.12.js"></script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
@endsection