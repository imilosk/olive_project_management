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

        <div id="taskInfo" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="text" id="taskInfo_name" value="Programiranje front-enda"> 
                    <div id="taskInfo_status">
                        <div id="taskInfo_open" class="task_status s_open"></div>
                        <div id="taskInfo_inprogress" class="task_status s_inprogress"></div>
                        <div id="taskInfo_review" class="task_status s_review"></div>
                        <div id="taskInfo_rejected" class="task_status s_rejected"></div>
                        <div id="taskInfo_closed" class="task_status s_closed"></div>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="task-description"></div>
                </div>
                <div class="modal-footer" id="taskInfo_modal-footer"></div>
            </div>
        </div>

		<div id="test">@php echo $auth->getUserId(); @endphp</div>
        
		<div id="project-tasks"></div>

        {{-- <div id="joke">STOPAR!</div> --}}

	</div>

<script type="text/x-handlebars-template" id="project-tasks-handle">

	<div class='project-tasks-container'>
		<div class='task-container' id='task-status-open'>
			<div class='task-div'>
                <div class='task-status'>OPEN</div>
                <div class='task-add' onclick='addTaskToProject(1)'>+</div>
            </div>
            <div class="add-task-form"></div>
			<div class='tasks'>
				@{{#each OPEN}}
					<div class='task'>
                        <div class='task-info'>
                            <div class='task_name'>@{{taskName}}</div>
                            <div class='task-settings' onclick='showTaskInfo(@{{idTask}})'></div>
                        </div>
                        <div class='task_status-change'>
                            <div class='task-status-text'>change status to</div>
                            <div class='task_ch-status'>
                                <div class='task_status s_inprogress' onclick='changeTaskStatus(@{{idTask}},3)'></div>
                                <div class='task_status s_review' onclick='changeTaskStatus(@{{idTask}},4)'></div>
                                <div class='task_status s_rejected' onclick='changeTaskStatus(@{{idTask}},5)'></div>
                                <div class='task_status s_closed' onclick='changeTaskStatus(@{{idTask}},2)'></div>
                            </div>
                        </div>
                    </div>
				@{{/each}}
			</div>
		</div>

		<div class='task-container' id='task-status-in_progress'>
			<div class='task-div'>
                <div class='task-status'>IN PROGRESS</div>
                <div class='task-add' onclick='addTaskToProject(3)'>+</div>
            </div>
			<div class='tasks'>
				@{{#each IN_PROGRESS}}
					<div class='task'>
                        <div class='task-info'>
                            <div class='task_name'>@{{taskName}}</div>
                            <div class='task-settings' onclick='showTaskInfo(@{{idTask}})'></div>
                        </div>
                        <div class='task_status-change'>
                            <div class='task-status-text'>change status to</div>
                            <div class='task_ch-status'>
                                <div class='task_status s_open' onclick='changeTaskStatus(@{{idTask}},1)'></div>
                                <div class='task_status s_review' onclick='changeTaskStatus(@{{idTask}},4)'></div>
                                <div class='task_status s_rejected' onclick='changeTaskStatus(@{{idTask}},5)'></div>
                                <div class='task_status s_closed' onclick='changeTaskStatus(@{{idTask}},2)'></div>
                            </div>
                        </div>
                    </div>
				@{{/each}}
			</div>
		</div>

        <div class='task-container' id='task-status-review'>
            <div class='task-div'>
                <div class='task-status'>REVIEW</div>
                <div class='task-add' onclick='addTaskToProject(4)'>+</div>
            </div>
            <div class='tasks'>
                @{{#each REVIEW}}
                    <div class='task'>
                        <div class='task-info'>
                            <div class='task_name'>@{{taskName}}</div>
                            <div class='task-settings' onclick='showTaskInfo(@{{idTask}})'></div>
                        </div>
                        <div class='task_status-change'>
                            <div class='task-status-text'>change status to</div>
                            <div class='task_ch-status'>
                                <div class='task_status s_open' onclick='changeTaskStatus(@{{idTask}},1)'></div>
                                <div class='task_status s_inprogress' onclick='changeTaskStatus(@{{idTask}},3)'></div>
                                <div class='task_status s_rejected' onclick='changeTaskStatus(@{{idTask}},5)'></div>
                                <div class='task_status s_closed' onclick='changeTaskStatus(@{{idTask}},2)'></div>
                            </div>
                        </div>
                    </div>
                @{{/each}}
            </div>
        </div>

        <div class='task-container' id='task-status-rejected'>
            <div class='task-div'>
                <div class='task-status'>REJECTED</div>
                <div class='task-add' onclick='addTaskToProject(1)'>+</div>
            </div>
            <div class='tasks'>
                @{{#each REJECTED}}
                    <div class='task'>
                        <div class='task-info'>
                            <div class='task_name'>@{{taskName}}</div>
                            <div class='task-settings' onclick='showTaskInfo(@{{idTask}})'></div>
                        </div>
                        <div class='task_status-change'>
                            <div class='task-status-text'>change status to</div>
                            <div class='task_ch-status'>
                                <div class='task_status s_open' onclick='changeTaskStatus(@{{idTask}},1)'></div>
                                <div class='task_status s_inprogress' onclick='changeTaskStatus(@{{idTask}},3)'></div>
                                <div class='task_status s_review' onclick='changeTaskStatus(@{{idTask}},4)'></div>
                                <div class='task_status s_closed' onclick='changeTaskStatus(@{{idTask}},2)'></div>
                            </div>
                        </div>
                    </div>
                @{{/each}}
            </div>
        </div>
        <div class='task-container' id='task-status-closed'>
            <div class='task-div'>
                <div class='task-status'>CLOSED</div>
                <div class='task-add' onclick='addTaskToProject(1)'>+</div>
            </div>
            <div class='tasks'>
                @{{#each CLOSED}}
                    <div class='task'>
                        <div class='task-info'>
                            <div class='task_name'>@{{taskName}}</div>
                            <div class='task-settings' onclick='showTaskInfo(@{{idTask}})'></div>
                        </div>
                        <div class='task_status-change'>
                            <div class='task-status-text'>change status to</div>
                            <div class='task_ch-status'>
                                <div class='task_status s_open' onclick='changeTaskStatus(@{{idTask}},1)'></div>
                                <div class='task_status s_inprogress' onclick='changeTaskStatus(@{{idTask}},3)'></div>
                                <div class='task_status s_review' onclick='changeTaskStatus(@{{idTask}},4)'></div>
                                <div class='task_status s_rejected' onclick='changeTaskStatus(@{{idTask}},5)'></div>
                            </div>
                        </div>
                    </div>
                @{{/each}}
            </div>
        </div>
	</div>
</script>

<script type="text/x-handlebars-template" id="taskInfo-user-list-handle">
    <div id="taskInfo_users-text">Users</div>
    <div id="taskInfo_users">
        @{{#each this}}
            <div class="taskInfo_user">
                @{{#isMe idUser}}
                    <div class='ului-email'>@{{email}} (Me)</div>
                @{{else}}
                    <div class='ului-email'>@{{email}}</div>
                @{{/isMe}}
                <div class='ului-settings row'>
                    <div class='uluis-id user-setting-item'>User id : @{{idUser}}</div>
                    <div class='uluis-remove user-setting-item' onclick='removeUserFromTask(@{{idUser}}, event)'>-</div>
                </div>
            </div>
        @{{/each}}
    </div
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
                                    <div onclick='getProjectTasks(@{{idProject}})' class='project-name'>@{{pName}}</div> 
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