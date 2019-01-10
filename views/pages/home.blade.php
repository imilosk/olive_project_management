@extends('../body') 

@php
    global $auth;
@endphp

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

    <div id="wrapper" class="container">
    	
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

		<div id="joke">STOPAR!</div>

		<div class="container">
			<div id="project-tasks"></div>
		</div>

	</div>


<script type="text/x-handlebars-template" id="project-tasks-handle">
	<div class='project-tasks-container'>
		<div class='task-container' id='task-status-open'>
			<div class='task-status'>OPEN</div>
			<div class='tasks'>
				@{{each open}}
					<div class='task'></div>
				@{{/each}}
			</div>
		</div>
		<div class='task-container' id='task-status-in_progress'>
			<div class='task-status'>IN PROGRESS</div>
			<div class='tasks'>
				@{{each in_progress}}
					<div class='task'></div>
				@{{/each}}
			</div>
		</div>
	</div>
</script>

<script type="text/x-handlebars-template" id="menu-user-list-handle">
@{{#each this}}
    <div class='ul-user row'>
        <div class='ulu-info'>
            @{{#isMe id}}
                <div class='ului-email'>@{{email}} (Me)</div>
            @{{else}}
                <div class='ului-email'>@{{email}}</div>
            @{{/isMe}}
            <div class='ului-settings row'>
            <div class='uluis-id user-setting-item'>User id : @{{id}}</div>
                <div class='uluis-remove user-setting-item' onclick='removeUserFromProject(@{{id}}, event)'>-</div>
            </div>
        </div>
    </div>
@{{/each}}
</script>

<script type="text/x-handlebars-template" id="side-menu-handle">
@{{#each this}} 
    <div class='org-list'> 
        <div class='org-container'> 
            <div class='org-div'> 
                <div class='org-name'>@{{orgName}}</div> 
                <div class='org-options'> 
                    <div class='org-options-users org-option' onclick='showUsers(@{{idOrganisation}}, 0)'>U</div> 
                    <div class='org-option-add-project org-option' onclick='displayAddProjectForm(@{{idOrganisation}}, event)'>+</div> 
                    <div class='org-option-remove org-option' onclick='deleteOrganisation(@{{idOrganisation}})'>-</div> 
                    <div class='add-project-div' id='org@{{idOrganisation}}-addProject_form'> 
                        <input type='text' placeholder='Name'> 
                        <input type='text' placeholder='Description'> 
                        <div class='small-btn' onclick='addProjectToOrganisation(@{{idOrganisation}}, event)'> Add </div> 
                    </div>  
                </div> 
            </div> 
            <div class='project-users'> 
                <div id='org@{{idOrganisation}}' class='users-list'></div> 
                @{{#isMeLeader orgLeaderId}} 
                    <div class='project-users-settings'> 
                        <div class='pus-add-user row'> 
                            <input type='text' id='org@{{idOrganisation}}_newUser'class='new-user-id' placeholder='new users email'>  
                            <span class='add-stuff-icon' onclick='addUserToOrganisation(@{{idOrganisation}})'>+</span> 
                        </div>    
                    </div> 
                @{{/isMeLeader}} 
            </div> 
            <div class='projects-list'> 
                @{{#each this}} 
                    @{{#if idProject}}
                        @{{#saveProInfo idProject idLeader}}@{{/saveProInfo}} 
                        <div class='pro-div'> 
                            <div class='project-properties'> 
                                <div class='row'> 
                                    <div onclick='proOnClick(@{{idProject}})' class='project-name'>@{{pName}}</div> 
                                    <div class='pro-options row'> 
                                        <div class='users-project pro-option' onclick='showUsers(@{{idProject}}, 1)'>u</div> 
                                        @{{#isMeLeader idLeader}} 
                                            <div class='del-project pro-option' onclick='deleteProject(@{{idProject}})'>-</div> 
                                        @{{/isMeLeader}} 
                                    </div> 
                                </div> 
                            </div> 
                            <div class='project-users'> 
                                <div id='pro@{{idProject}}' class='users-list'></div> 
                                @{{#isMeLeader idLeader}} 
                                    <div class='project-users-settings'> 
                                        <div class='pus-add-user row'> 
                                            <span class='add-stuff-icon' onclick='addUserToProject(@{{idProject}})'>+</span> 
                                            <input type='text' id='pro@{{idProject}}_newUser' class='new-user-id' placeholder='new users id'>  
                                    </div> 
                                @{{/isMeLeader}} 
                            </div> 
                        </div> 
                    @{{/if}} 
                @{{/each}} 
            </div> 
        </div> 
    </div> 
@{{/each}}
</script>

<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/handlebars-v4.0.12.js"></script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
@endsection