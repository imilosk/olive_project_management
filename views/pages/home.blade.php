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

                <div class="modal-footer" id="addOrgForm">
                    <div id="addOrganisationModal_header">Add organisation</div>
                    <div id="addOrganisationModal_body">
                        <input type="text" id="addOrganisation-name" name="name" placeholder="Name">
                        <textarea id="addOrganisation-description" placeholder="Description"></textarea>
                    </div>
                    <div id="btn-addNewOrganisation">Create</div>
                </div>
			  	<div class="modal-footer">
			  		<div id="btn-openOrganisationModal" data-toggle="tooltip" title="test">Add Organisation</div>
			  	</div>
			</div>
		</div>

        <div id="taskInfo" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <input type="text" id="taskInfo_name" name="taskInfo_name-input" placeholder="Task name" onchange="updateTaskName()"> 
                    <div id="taskInfo_status">
                        <div id="taskInfo_open" class="task_status s_open" onclick="changeTaskStatus(0, 1)"></div>
                        <div id="taskInfo_inprogress" class="task_status s_inprogress" onclick="changeTaskStatus(0, 3)"></div>
                        <div id="taskInfo_review" class="task_status s_review" onclick="changeTaskStatus(0, 4)"></div>
                        <div id="taskInfo_rejected" class="task_status s_rejected" onclick="changeTaskStatus(0, 5)"></div>
                        <div id="taskInfo_closed" class="task_status s_closed" onclick="changeTaskStatus(0, 2)"></div>
                    </div>
                </div>
                <div class="modal-body">
                    <div id="task-description">
                        <textarea id="task-description-text" placeholder="Description" onchange="updateTaskDescription()"></textarea>
                    </div>
                </div>
                <div class="modal-footer" id="taskInfo_modal-footer"></div>
            </div>
        </div>

        <div id="navPSP-tasks" class="modal">
            <!-- Overlay content --> 
            <div class="modal-content">
                <div class="modal-header">Time Notes</div>
                <div class="modal-body">
                    <div id="psp_forms">
                        <div id="psp-form_1">
                            <div class="row">
                                <div class="form-group">
                                    <label for="insertphase">Phase</label>
                                    <select id="idPhase" class="form-control">
                                        <option value="" selected disabled hidden>Choose here</option>
                                        <option value="1">Planning</option>
                                        <option value="2">Infrastructuring</option>
                                        <option value="3">Coding</option>
                                        <option value="4">Code review</option>
                                        <option value="5">Compiling</option>
                                        <option value="6">Testing</option>
                                        <option value="7">Analysis</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="estimatedtime">Estimated time</label>
                                    <input type="number" class="form-control" id="estimatedtime" placeholder="(Min)">
                                </div>

                                <div class="form-group">
                                    <label for="estimatedunits">Estimated units</label>
                                    <input type="number" class="form-control" id="estimatedunits">
                                </div>
                           
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="startDate">Start-date</label>
                                    <input type="date" class="form-control" id="startDate">
                                </div>

                                <div class="form-group">
                                    <label for="startTime">Start-time</label>
                                    <input type="time" class="form-control" id="startTime">
                                </div>

                                <div class="form-group">
                                    <label for="endDate">End-date</label>
                                    <input type="date" id="endDate" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="endTime">End-time</label>
                                    <input type="time" id="endTime" class="form-control">
                                </div>
                            </div>      
                        </div>
                        <div id="psp-form_2">

                            <div class="row">
                                <div class="form-group">
                                    <label for="units">Units</label>
                                    <input type="number" class="form-control" id="units" >
                                </div>

                                <div class="form-group">
                                    <label for="pause">Interruption</label>
                                    <input type="number" class="form-control" id="pause" placeholder="(Min)">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description"></textarea>
                            </div>

                            <div id="psp-task-submit" onclick="addPSPTask()">+</div>
                        </div>
                    </div>
                    <div id="tasks-record-list"></div>
                </div>
            </div>
        </div>

		<div id="test">@php echo $auth->getUserId(); @endphp</div>
        
		<div id="project-tasks"></div>

        <div id="navPSP" class="modal"></div>

        <div id="navPSPError" class="modal">
            <!-- Overlay content --> 
            <div id="frame" class="modal-content">
                <div class="modal-header">Mistakes Notes</div>
                <div class="modal-body">
                    <div id="error-form">
                        <div class="row">
                            <div class="form-group">
                                <label for="phaseEntry">Phase Entry</label>
                                <select id="phaseEntry" class="form-control">
                                    <option value="" selected disabled hidden>Choose here</option>
                                    <option value="1">Planning</option>
                                    <option value="2">Infrastructuring</option>
                                    <option value="3">Coding</option>
                                    <option value="4">Code review</option>
                                    <option value="5">Compiling</option>
                                    <option value="6">Testing</option>
                                    <option value="7">Analysis</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="phaseFinish">Phase Finish</label>
                                <select id="phaseFinish" class="form-control">
                                    <option value="" selected disabled hidden>Choose here</option>
                                    <option value="1">Planning</option>
                                    <option value="2">Infrastructuring</option>
                                    <option value="3">Coding</option>
                                    <option value="4">Code review</option>
                                    <option value="5">Compiling</option>
                                    <option value="6">Testing</option>
                                    <option value="7">Analysis</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select id="category" class="form-control">
                                    <option value="" selected disabled hidden>Choose here</option>
                                    <option value="2">Documentation</option>
                                    <option value="3">Syntax</option>
                                    <option value="4">Construction</option>
                                    <option value="5">Arranging</option>
                                    <option value="6">Interface</option>
                                    <option value="7">Checking</option>
                                    <option value="8">Data</option>
                                    <option value="9">Functions</option>
                                    <option value="10">System</option>
                                    <option value="11">Environment</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="resolve_time">Resolve time</label>
                                <input type="number" class="form-control" id="resolve_time">
                            </div>
                            <div class="form-group">
                                <label for="num_fixed_errors"># of fixed errors</label>
                                <input type="number" class="form-control" id="num_fixed_errors">
                            </div>
                        </div>

                        <div class="row">                               
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="error_description"></textarea>
                            </div>
                        </div>    
                        <div id="psp-task-submit" onclick="addPSPError()">+</div>  
                    </div>
                    <div id="error-list">
                        
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>

        {{-- <div id="joke">STOPAR!</div> --}}

	</div>

<script type="text/x-handlebars-template" id="error-PSP-handle">
    <div id="error-inside-list">
        <div id="t-headers">
            <div class="t-header">Category</div>
            <div class="t-header">Phase Entry</div>
            <div class="t-header">Phase Finish</div>
            <div class="t-header">Resolve time</div>
            <div class="t-header"># Fixed Errors</div>
            <div class="t-header">Info</div>
        </div>
        @{{#each this}}
            <div id="record_@{{id}}" class="record row">
                <div id="record_id_@{{id}}" class="record_hidden record_item">@{{id}}</div>
                <div id="record_pIdEntry_@{{id}}" class="record_hidden record_item">@{{pIdEntry}}</div>
                <div id="record_category_@{{id}}" class="record_item">@{{category}}</div>
                <div id="record_pIdFinish_@{{id}}" class="record_hidden record_item">@{{pIdFinish}}</div>
                <div id="record_phaseFinish_@{{id}}"class="record_item">@{{phaseFinish}}</div>
                <div id="record_idCategory_@{{id}}" class="record_hidden record_item">@{{idCategory}}</div>
                <div id="record_phaseEntry_@{{id}}"class="record_item">@{{phaseEntry}}</div>              
                <div id="record_resolve_time_@{{id}}"class="record_item">@{{resolve_time}}</div>
                <div id="record_num_fixed_errors_@{{id}}"class="record_item">@{{num_fixed_errors}}</div>
                <div id="record_description_@{{id}}" class="record_hidden record_item">@{{description}}</div>
                <div id="info_btn_@{{id}}" class="record_item details-btn" onclick="showPSPErrorRecord(@{{id}})">details</div>
                <div id="delete_btn_@{{id}}" class="record_item delete-btn" onclick="deletePSPErrorRecord(@{{id}})">X</div>
            </div>
        @{{/each}}
    </div>
</script>

<script type="text/x-handlebars-template" id="tasks-PSP-handle">
        <div id="inside-list">
            <div id="t-headers">
                <div class="t-header">Phase</div>
                <div class="t-header">Start date</div>
                <div class="t-header">End date</div>
                <div class="t-header">Units</div>
                <div class="t-header">Info</div>
            </div>
            @{{#each this}}
                <div class="record" id="record_@{{id}}" class="row">
                    <div id="record_id_@{{id}}" class="record_hidden record_item">@{{id}}</div>
                    <div id="record_phaseid_@{{id}}" class="record_hidden record_item">@{{idPhase}}</div>
                    <div id="record_phase_@{{id}}" class="record_item" >@{{name}}</div>
                    <div id="record_startDate_@{{id}}" class="record_item" >@{{startDate}}</div>
                    <div id="record_startTime_@{{id}}" class="record_hidden record-item">@{{startTime}}</div>
                    <div id="record_endDate_@{{id}}" class="record_item" >@{{endDate}}</div>
                    <div id="record_endTime_@{{id}}" class="record_hidden record-item">@{{endTime}}</div>
                    <div id="record_pause_@{{id}}" class="record_hidden record-item">@{{pause}}</div>
                    <div id="record_estimatedtime_@{{id}}" class="record_hidden record-item">@{{estimatedtime}}</div>
                    <div id="record_estimatedunits_@{{id}}" class="record_hidden record-item">@{{estimatedunits}}</div>
                    <div id="record_units_@{{id}}" class="record_item" >@{{units}}</div>
                    <div id="record_description_@{{id}}" class="record_hidden record-item">@{{description}}</div>
                    <div id="record_info_btn_@{{id}}" class="record_item details-btn" onclick="showPSPTaskRecord(@{{id}})">details</div>
                    <div id="record_delete_btn_@{{id}}" class="record_item delete-btn" onclick="deletePSPTaskRecord(@{{id}})">X</div>
                </div>
            @{{/each}}
        </div>
</script>

<script type="text/x-handlebars-template" id="taskInfo-add_user-list-handle">
    <div id="taskInfo-add_user-options">
        <div id="taskInfo-add_user-text">Available users</div>
    </div>
    <div id="taskInfo-add_user_users">
        @{{#each this}}
            <div class="taskInfo-add_user">
                @{{#isMe id}}
                    <div class='ului-email'>@{{email}} (Me)</div>
                @{{else}}
                    <div class='ului-email'>@{{email}}</div>
                @{{/isMe}}
                <div class='ului-settings row'>
                    <div class='uluis-id user-setting-item'>User id : @{{idUser}}</div>
                    <div class='uluis-remove user-setting-item' onclick='addUserToTask(@{{idUser}}, event)'>+</div>
                </div>
            </div>
        @{{/each}}
    </div>
</script>

<script type="text/x-handlebars-template" id="taskInfo-user-list-handle">
    <div id="taskInfo_options" class="row">
        <div id="taskInfo_users-text">Users assigned to this task</div>
        <div id="taskInfo_users-add_users" onclick="getAvailableUsers(event, 0)">+</div>
    </div>
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

<script type="text/x-handlebars-template" id="project-tasks-handle">

	<div class='project-tasks-container'>
		<div class='task-container' id='task-status-open'>
			<div class='task-div'>
                <div class='task-status'>OPEN</div>
                <div class='task-add' onclick='showAddTaskForm(1)'>+</div>
            </div>
            <div class="add-task-form" id="add-task-form_1" style="display:none;">
                <input type="text" class="task-name_input" id="task_name_1" placeholder="Task name">
                <div class="task-add" onclick="addTaskToProject(1)"">+</div>
            </div>
			<div class='tasks'>
				@{{#each OPEN}}
					<div class='task'>
                        <div class="task-overview">
                            <div class='task-info'>
                                <div class='task_name' id="task_name-taks_@{{idTask}}">@{{taskName}}</div>
                                <div class='task-settings fa fa-gear task-option' onclick='getTaskInfo(@{{idTask}})'></div>
                            </div>


                            <div class="tasks-options">
                                <div class="tasks-left-options">
                                    @{{#hasTaskAccess access}}
                                        <div class="tasks-psp-mistakes task-option fa fa-warning" data-toggle="tooltip" title="Mistake notes" onclick="getPSPMistakes(@{{idTask}})"></div>
                                        <div class="tasks-psp-overview task-option" onclick="getPSPData(@{{idTask}})">O</div>
                                        <div class="task-option" onclick="getPSPTaskData(@{{idTask}})">N</div>
                                    @{{/hasTaskAccess}}
                                </div>
                                <div class="tasks-right-options">
                                    @{{#hasTaskAccess access}}
                                        <div class="task-delete task-option" onclick="deleteTask(@{{idTask}})" data-toggle="tooltip" title="Delete task">X</div>
                                    @{{/hasTaskAccess}}
                                </div>
                            </div>


                            <div class='task_status-change row'>
                                <div class='task_ch-status'>
                                    <div class='task-status-text'>change status to</div>
                                    <div class='task-statuses row'>
                                        <div class='task_status s_inprogress' onclick='changeTaskStatus(@{{idTask}},3)' data-toggle="tooltip" title="In progress" ></div>
                                        <div class='task_status s_review' onclick='changeTaskStatus(@{{idTask}},4)'></div>
                                        <div class='task_status s_rejected' onclick='changeTaskStatus(@{{idTask}},5)'></div>
                                        <div class='task_status s_closed' onclick='changeTaskStatus(@{{idTask}},2)'></div>
                                    </div>
                                </div>
                                <div onclick="getAvailableUsers(event, @{{idTask}})" data-toggle="tooltip" title="Add user" class="fa fa-user-plus add-user task-option"></div>
                            </div>
                        </div>
                        
                    </div>
				@{{/each}}
			</div>
		</div>

		<div class='task-container' id='task-status-in_progress'>
			<div class='task-div'>
                <div class='task-status'>IN PROGRESS</div>
                <div class='task-add' onclick='showAddTaskForm(3)'>+</div>
            </div>
            <div class="add-task-form" id="add-task-form_3" style="display:none;">
                <input type="text" class="task-name_input" id="task_name_3" placeholder="Task name">
                <div class="task-add" onclick="addTaskToProject(3)"">+</div>
            </div>
			<div class='tasks'>
				@{{#each IN_PROGRESS}}
					<div class='task'>
                        <div class='task-info'>
                            <div class='task_name' id="task_name-taks_@{{idTask}}">@{{taskName}}</div>
                            <div class='task-settings fa fa-gear task-option' onclick='getTaskInfo(@{{idTask}})'></div>
                        </div>

                        <div class="tasks-options">
                            <div class="tasks-left-options">
                                @{{#hasTaskAccess access}}
                                    <div class="tasks-psp-mistakes task-option fa fa-warning" data-toggle="tooltip" title="Mistake notes" onclick="getPSPMistakes(@{{idTask}})"></div>
                                    <div class="tasks-psp-overview task-option" onclick="getPSPData(@{{idTask}})">O</div>
                                    <div class="task-option" onclick="getPSPTaskData(@{{idTask}})">N</div>
                                @{{/hasTaskAccess}}
                            </div>
                            <div class="tasks-right-options">
                                @{{#hasTaskAccess access}}
                                    <div class="task-delete task-option" onclick="deleteTask(@{{idTask}})" data-toggle="tooltip" title="Delete task">X</div>
                                @{{/hasTaskAccess}}
                            </div>
                        </div>

                        <div class='task_status-change row'>
                            <div class='task_ch-status'>
                                <div class='task-status-text'>change status to</div>
                                <div class='task-statuses row'>
                                    <div class='task_status s_open' onclick='changeTaskStatus(@{{idTask}},1)' data-toggle="tooltip" title="In progress" ></div>
                                    <div class='task_status s_review' onclick='changeTaskStatus(@{{idTask}},4)'></div>
                                    <div class='task_status s_rejected' onclick='changeTaskStatus(@{{idTask}},5)'></div>
                                    <div class='task_status s_closed' onclick='changeTaskStatus(@{{idTask}},2)'></div>
                                </div>
                            </div>
                            <div onclick="getAvailableUsers(event, @{{idTask}})" data-toggle="tooltip" title="Add user" class="fa fa-user-plus add-user task-option"></div>
                        </div>
                    </div>
				@{{/each}}
			</div>
		</div>

        <div class='task-container' id='task-status-review'>
            <div class='task-div'>
                <div class='task-status'>REVIEW</div>
                <div class='task-add' onclick='showAddTaskForm(4)'>+</div>
            </div>
            <div class="add-task-form" id="add-task-form_4" style="display:none;">
                <input type="text" class="task-name_input" id="task_name_4" placeholder="Task name">
                <div class="task-add" onclick="addTaskToProject(4)"">+</div>
            </div>
            <div class='tasks'>
                @{{#each REVIEW}}
                    <div class='task'>
                        <div class='task-info'>
                            <div class='task_name' id="task_name-taks_@{{idTask}}">@{{taskName}}</div>
                            <div class='task-settings fa fa-gear task-option' onclick='getTaskInfo(@{{idTask}})'></div>
                        </div>

                        <div class="tasks-options">
                            <div class="tasks-left-options">
                                @{{#hasTaskAccess access}}
                                    <div class="tasks-psp-mistakes task-option fa fa-warning" data-toggle="tooltip" title="Mistake notes" onclick="getPSPMistakes(@{{idTask}})"></div>
                                    <div class="tasks-psp-overview task-option" onclick="getPSPData(@{{idTask}})">O</div>
                                    <div class="task-option" onclick="getPSPTaskData(@{{idTask}})">N</div>
                                @{{/hasTaskAccess}}
                            </div>
                            <div class="tasks-right-options">
                                @{{#hasTaskAccess access}}
                                    <div class="task-delete task-option" onclick="deleteTask(@{{idTask}})" data-toggle="tooltip" title="Delete task">X</div>
                                @{{/hasTaskAccess}}
                            </div>
                        </div>

                        <div class='task_status-change row'>
                            <div class='task_ch-status'>
                                <div class='task-status-text'>change status to</div>
                                <div class='task-statuses row'>
                                    <div class='task_status s_open' onclick='changeTaskStatus(@{{idTask}},1)' data-toggle="tooltip" title="In progress" ></div>
                                    <div class='task_status s_inprogress' onclick='changeTaskStatus(@{{idTask}},3)'></div>
                                    <div class='task_status s_rejected' onclick='changeTaskStatus(@{{idTask}},5)'></div>
                                    <div class='task_status s_closed' onclick='changeTaskStatus(@{{idTask}},2)'></div>
                                </div>
                            </div>
                            <div onclick="getAvailableUsers(event, @{{idTask}})" data-toggle="tooltip" title="Add user" class="fa fa-user-plus add-user task-option"></div>
                        </div>
                    </div>
                @{{/each}}
            </div>
        </div>

        <div class='task-container' id='task-status-rejected'>
            <div class='task-div'>
                <div class='task-status'>REJECTED</div>
                <div class='task-add' onclick='showAddTaskForm(5)'>+</div>
            </div>
            <div class="add-task-form" id="add-task-form_5" style="display:none;">
                <input type="text" class="task-name_input" id="task_name_5" placeholder="Task name">
                <div class="task-add" onclick="addTaskToProject(5)"">+</div>
            </div>
            <div class='tasks'>
                @{{#each REJECTED}}
                    <div class='task'>
                        <div class='task-info'>
                            <div class='task_name' id="task_name-taks_@{{idTask}}">@{{taskName}}</div>
                            <div class='task-settings fa fa-gear task-option' onclick='getTaskInfo(@{{idTask}})'></div>
                        </div>

                        <div class="tasks-options">
                            <div class="tasks-left-options">
                                @{{#hasTaskAccess access}}
                                    <div class="tasks-psp-mistakes task-option fa fa-warning" data-toggle="tooltip" title="Mistake notes" onclick="getPSPMistakes(@{{idTask}})"></div>
                                    <div class="tasks-psp-overview task-option" onclick="getPSPData(@{{idTask}})">O</div>
                                    <div class="task-option" onclick="getPSPTaskData(@{{idTask}})">N</div>
                                @{{/hasTaskAccess}}
                            </div>
                            <div class="tasks-right-options">
                                @{{#hasTaskAccess access}}
                                    <div class="task-delete task-option" onclick="deleteTask(@{{idTask}})" data-toggle="tooltip" title="Delete task">X</div>
                                @{{/hasTaskAccess}}
                            </div>
                        </div>

                        <div class='task_status-change row'>
                            <div class='task_ch-status'>
                                <div class='task-status-text'>change status to</div>
                                <div class='task-statuses row'>
                                    <div class='task_status s_open' onclick='changeTaskStatus(@{{idTask}},1)' data-toggle="tooltip" title="In progress" ></div>
                                    <div class='task_status s_inprogress' onclick='changeTaskStatus(@{{idTask}},3)'></div>
                                    <div class='task_status s_review' onclick='changeTaskStatus(@{{idTask}},4)'></div>
                                    <div class='task_status s_closed' onclick='changeTaskStatus(@{{idTask}},2)'></div>
                                </div>
                            </div>
                            <div onclick="getAvailableUsers(event, @{{idTask}})" data-toggle="tooltip" title="Add user" class="fa fa-user-plus add-user task-option"></div>
                        </div>
                    </div>
                @{{/each}}
            </div>
        </div>

        <div class='task-container' id='task-status-closed'>
            <div class='task-div'>
                <div class='task-status'>CLOSED</div>
                <div class='task-add' onclick='showAddTaskForm(2)'>+</div>
            </div>
            <div class="add-task-form" id="add-task-form_2" style="display:none;">
                <input type="text" class="task-name_input" id="task_name_2" placeholder="Task name">
                <div class="task-add" onclick="addTaskToProject(2)"">+</div>
            </div>
            <div class='tasks'>
                @{{#each CLOSED}}
                    <div class='task'>
                        <div class='task-info'>
                            <div class='task_name' id="task_name-taks_@{{idTask}}">@{{taskName}}</div>
                            <div class='task-settings fa fa-gear task-option' onclick='getTaskInfo(@{{idTask}})'></div>
                        </div>

                        <div class="tasks-options">
                            <div class="tasks-left-options">
                                @{{#hasTaskAccess access}}
                                    <div class="tasks-psp-mistakes task-option fa fa-warning" data-toggle="tooltip" title="Mistake notes" onclick="getPSPMistakes(@{{idTask}})"></div>
                                    <div class="tasks-psp-overview task-option" onclick="getPSPData(@{{idTask}})">O</div>
                                    <div class="task-option" onclick="getPSPTaskData(@{{idTask}})">N</div>
                                @{{/hasTaskAccess}}
                            </div>
                            <div class="tasks-right-options">
                                @{{#hasTaskAccess access}}
                                    <div class="task-delete task-option" onclick="deleteTask(@{{idTask}})" data-toggle="tooltip" title="Delete task">X</div>
                                @{{/hasTaskAccess}}
                            </div>
                        </div>

                        <div class='task_status-change row'>
                            <div class='task_ch-status'>
                                <div class='task-status-text'>change status to</div>
                                <div class='task-statuses row'>
                                    <div class='task_status s_open' onclick='changeTaskStatus(@{{idTask}},1)' data-toggle="tooltip" title="In progress" ></div>
                                    <div class='task_status s_inprogress' onclick='changeTaskStatus(@{{idTask}},3)'></div>
                                    <div class='task_status s_review' onclick='changeTaskStatus(@{{idTask}},4)'></div>
                                    <div class='task_status s_rejected' onclick='changeTaskStatus(@{{idTask}},5)'></div>
                                </div>
                            </div>
                            <div onclick="getAvailableUsers(event, @{{idTask}})" data-toggle="tooltip" title="Add user" class="fa fa-user-plus add-user task-option"></div>
                        </div>

                    </div>
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
                    @{{#isMeLeader}}
                        <div class='uluis-remove user-setting-item' onclick='removeUserFromProject(@{{id}}, event)'>-</div>
                        <div class='user-setting-item' onclick='getUserPSPData(@{{id}})'>O</div>
                    @{{/isMeLeader}}
                </div>
            </div>
        </div>
    @{{/each}}
</script>

<script type="text/x-handlebars-template" id="side-menu-handle">
    @{{#each this}} 
        @{{#saveOrgInfo idOrganisation orgLeaderId}}@{{/saveOrgInfo}}
        <div class='org-list'> 
            <div class='org-container'> 
                <div class='org-div'> 
                    <div class='org-name'>@{{orgName}}</div> 
                    <div class='org-options'> 
                        <div class='org-options-users org-option' onclick='showUsers(@{{idOrganisation}}, 0)'>U</div> 
                        <div class='org-option-add-project org-option' onclick='displayAddProjectForm(@{{idOrganisation}})'>+</div> 
                        @{{#isMeLeaderPO orgLeaderId}}
                            <div class='org-option-remove org-option' onclick='deleteOrganisation(@{{idOrganisation}})'>-</div> 
                        @{{/isMeLeaderPO}}
                        <div class='add-project-div' id='org@{{idOrganisation}}-addProject_form'> 
                            <input type='text' placeholder='Name'> 
                            <input type='text' placeholder='Description'> 
                            <div class='small-btn' onclick='addProjectToOrganisation(@{{idOrganisation}}, event)'> Add </div> 
                        </div>  
                    </div> 
                </div> 
                <div class='project-users'> 
                    <div id='org@{{idOrganisation}}' class='users-list'></div> 
                    @{{#isMeLeaderPO orgLeaderId}} 
                        <div class='project-users-settings'> 
                            <div class='pus-add-user row'> 
                                <input type='text' id='org@{{idOrganisation}}_newUser'class='new-user-id' placeholder='new users email'>  
                                <span class='add-stuff-icon' onclick='addUserToOrganisation(@{{idOrganisation}})'>+</span> 
                            </div>    
                        </div> 
                    @{{/isMeLeaderPO}} 
                </div> 
                <div class='projects-list'> 
                    @{{#each this}} 
                        @{{#if idProject}}
                            @{{#saveProInfo idProject idLeader}}@{{/saveProInfo}} 
                            <div class='pro-div'> 
                                <div class='project-properties'> 
                                    <div class='row'> 
                                        <div onclick='getProjectTasks(@{{idProject}}, @{{../idOrganisation}})' class='project-name'>@{{pName}}</div> 
                                        <div class='pro-options row'> 
                                            <div class='users-project pro-option' onclick='showUsers(@{{idProject}}, 1)'>u</div> 
                                            @{{#isMeLeaderPO idLeader}} 
                                                <div class='del-project pro-option' onclick='deleteProject(@{{idProject}})'>-</div> 
                                            @{{/isMeLeaderPO}} 
                                        </div> 
                                    </div> 
                                </div> 
                                <div class='project-users'> 
                                    <div id='pro@{{idProject}}' class='users-list'></div> 
                                    @{{#isMeLeaderPO idLeader}} 
                                        <div class='project-users-settings'> 
                                            <div class='pus-add-user row'> 
                                                <span class='add-stuff-icon' onclick='addUserToProject(@{{idProject}})'>+</span> 
                                                <input type='text' id='pro@{{idProject}}_newUser' class='new-user-id' placeholder='new users id'>  
                                        </div> 
                                    @{{/isMeLeaderPO}} 
                                </div> 
                            </div> 
                        @{{/if}} 
                    @{{/each}} 
                </div> 
            </div> 
        </div> 
    @{{/each}}
</script>

<script type="text/x-handlebars-template" id="psp-data-handle">
<!-- Button to close the overlay navigation -->
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
            
        <!-- Overlay content -->
            <div class="overlay-content">
                <div id="info">
                    <div class="info-e">
                        <div class="info-e_text">Task name</div>
                        <div class="info-e_main" id="task_name">@{{info.task}}</div>
                    </div>

                    <div class="info-e">
                        <div class="info-e_text">User email</div>
                        <div class="info-e_main">@{{user.email}}</div>
                    </div>

                    <div class="info-e">
                        <div class="info-e_text">Project leader</div>
                        <div class="info-e_main">@{{info.leaderEmail}}</div>
                    </div>

                    <div class="info-e">
                        <div class="info-e_text">project status</div>
                        <div class="info-e_main">@{{info.status}}</div>
                    </div>

                    <div class="info-e">
                        <div class="info-e_text">project id</div>
                        <div class="info-e_main">@{{ info.idPSP }}</div>
                    </div>

                    <div class="info-e">
                        <div class="info-e_text">Programing language</div>
                        <div class="info-e_main"><input type="input" id="prog_language" value="@{{info.programing_language}}" onchange="updatePLanguage( @{{info.idPSP}} )"></div>
                    </div>
                </div>
                <div id="data">
                    <fieldset>
                        <legend>Summary</legend>
                        <div class="table">
                        <div class="psp-row header">
                            <div class="cell">
                                
                            </div>
                            <div class="cell">
                                Plan:
                            </div>
                            <div class="cell">
                                Real values:
                            </div>
                            <div class="cell">
                                Till now:
                            </div>
                        </div>
                            <div class="psp-row">
                                <div class="cell"> Min/LOC: </div>
                                <div class="cell">@{{ summary.plan.minloc }}</div>
                                <div class="cell">@{{ summary.real.minloc }}</div>
                                <div class="cell">@{{user.minloc}}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> LOC/hour:</div>
                                <div class="cell">@{{ summary.plan.loch }}</div>
                                <div class="cell">@{{ summary.real.loch }}</div>
                                <div class="cell">@{{user.loch}}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> # of mistakes/KLOC: </div>
                                <div class="cell">@{{ summary.plan.miskloc }}</div>
                                <div class="cell">@{{ summary.real.miskloc }}</div>
                                <div class="cell">@{{user.miskloc}}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Ratio of fixing mistakes: </div>
                                <div class="cell">@{{ summary.plan.ratio }}</div>
                                <div class="cell">@{{ summary.real.ratio }}</div>
                                <div class="cell">@{{user.ratio}}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Searching/Fixing mistakes ratio: </div>
                                <div class="cell">@{{ summary.plan.sfratio }}</div>
                                <div class="cell">@{{ summary.real.sfratio }}</div>
                                <div class="cell">@{{user.sfratio}}</div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend>Size (Line of codes)</legend>
                        <div class="table">
                        <div class="psp-row header">
                            <div class="cell">
                                
                            </div>
                            <div class="cell">
                                Plan:
                            </div>
                            <div class="cell">
                                Real values:
                            </div>
                            <div class="cell">
                                Till now:
                            </div>
                        </div>
                            <div class="psp-row">
                                <div class="cell">Size(LOC):</div> <div class="cell">@{{ size.p_size }}</div> <div class="cell" id="sizeTask">@{{ size.a_size }}</div> <div class="cell" id="sizeSum">@{{ user.size }}</div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Development time (min)</legend>
                        <div class="table">
                        <div class="psp-row header">
                            <div class="cell">
                                
                            </div>
                            <div class="cell">
                                Plan:
                            </div>
                            <div class="cell">
                                Real values:
                            </div>
                            <div class="cell">
                                Till now:
                            </div>
                            <div class="cell">
                                Till now ratio (%):
                            </div>
                        </div>
                            <div class="psp-row">
                                <div class="cell">Planing </div><div class="cell">@{{ time.Planning.estimatedtime }}</div><div class="cell">@{{ time.Planning.time }}</div><div class="cell">@{{ user.planning_time }}</div><div class="cell">@{{ user.ratios.planning_time }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Infrastructuring</div><div class="cell">@{{ time.Infrastructuring.estimatedtime }}</div><div class="cell">@{{ time.Infrastructuring.time }}</div> <div class="cell">@{{ user.infrastructuring_time }}</div><div class="cell">@{{ user.ratios.infrastructuring_time }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Coding </div><div class="cell">@{{ time.Coding.estimatedtime }}</div><div class="cell">@{{ time.Coding.time }}</div><div class="cell">@{{ user.coding_time }}</div><div class="cell">@{{ user.ratios.coding_time }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Code review </div><div class="cell">@{{ time.Code_review.estimatedtime }}</div><div class="cell">@{{ time.Code_review.time }}</div><div class="cell">@{{ user.code_review_time }}</div><div class="cell">@{{ user.ratios.code_review_time }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Compiling </div><div class="cell">@{{ time.Compiling.estimatedtime }}</div><div class="cell">@{{ time.Compiling.time }}</div><div class="cell">@{{ user.compiling_time }}</div><div class="cell">@{{ user.ratios.compiling_time }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Testing </div><div class="cell">@{{ time.Testing.estimatedtime }}</div><div class="cell">@{{ time.Testing.time }}</div><div class="cell">@{{ user.testing_time }}</div><div class="cell">@{{ user.ratios.testing_time }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Analysis </div><div class="cell">@{{ time.Analysis.estimatedtime }}</div><div class="cell">@{{ time.Analysis.time }}</div><div class="cell">@{{ user.analysis_time }}</div><div class="cell">@{{ user.ratios.analysis_time }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Sum </div><div class="cell">@{{time.sum.plan_time}}</div><div class="cell" id="sumTask_time_dev">@{{time.sum.real_time}}</div><div class="cell" id="sumTask_time_dev">@{{user.sum_time}}</div><div class="cell" id="sum_time_dev">100</div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Insert errors</legend>
                        <div class="table">
                        <div class="psp-row header">
                            <div class="cell">
                                
                            </div>
                            <div class="cell">
                                Real values:
                            </div>
                            <div class="cell">
                                Till now:
                            </div>
                            <div class="cell">
                                Till now ratio (%):
                            </div>
                            <div class="cell">
                                Mistakes per hour:
                            </div>
                        </div>
                            <div class="psp-row">
                                <div class="cell">Planning </div>
                                <div class="cell">@{{ err.Planning.err }}</div>
                                <div class="cell">@{{ user.planning_in_err }}</div>
                                <div class="cell">@{{ user.ratios.planning_in_err }}</div>
                                <div class="cell">@{{  user.errh.planning_in_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Infrastructuring</div>
                                <div class="cell">@{{ err.Infrastructuring.err }}</div>
                                <div class="cell">@{{ user.infrastructuring_in_err }}</div>
                                <div class="cell">@{{ user.ratios.infrastructuring_in_err }}</div>
                                <div class="cell">@{{  user.errh.infrastructuring_in_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Coding </div>
                                <div class="cell">@{{ err.Coding.err }}</div>
                                <div class="cell">@{{ user.coding_in_err }}</div>
                                <div class="cell">@{{ user.ratios.coding_in_err }}</div>
                                <div class="cell">@{{  user.errh.coding_in_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Code review </div>
                                <div class="cell">@{{ err.Code_review.err }}</div>
                                <div class="cell">@{{ user.code_review_in_err }}</div>
                                <div class="cell">@{{ user.ratios.code_review_in_err }}</div>
                                <div class="cell">@{{  user.errh.code_review_in_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Compiling </div>
                                <div class="cell">@{{ err.Compiling.err }}</div>
                                <div class="cell">@{{ user.compiling_in_err }}</div>
                                <div class="cell">@{{ user.ratios.compiling_in_err }}</div>
                                <div class="cell">@{{  user.errh.compiling_in_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Testing </div>
                                <div class="cell">@{{ err.Testing.err }}</div>
                                <div class="cell">@{{ user.testing_in_err }}</div>
                                <div class="cell">@{{ user.ratios.testing_in_err }}</div>
                                <div class="cell">@{{  user.errh.testing_in_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Analysis </div>
                                <div class="cell">@{{ err.Analysis.err }}</div>
                                <div class="cell">@{{ user.analysis_in_err }}</div>
                                <div class="cell">@{{ user.ratios.analysis_in_err }}</div>
                                <div class="cell">@{{ user.errh.analysis_in_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Sum </div>
                                <div class="cell" id="sumTask_mistakes">@{{err.sum}}</div>
                                <div class="cell" id="sum_mistakes">@{{user.sum_in_err}}</div>
                                <div class="cell">100</div>
                                <div class="cell" id="sum_time_dev"></div>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Resloved errors</legend>
                        <div class="table">
                        <div class="psp-row header">
                            <div class="cell">
                                
                            </div>
                            <div class="cell">
                                Real values:
                            </div>
                            <div class="cell">
                                Till now:
                            </div>
                            <div class="cell">
                                Till now ratio (%):
                            </div>
                            <div class="cell">
                                Mistakes per hour:
                            </div>
                        </div>
                            <div class="psp-row">
                                <div class="cell">Planning </div>
                                <div class="cell">@{{ res.Planning.res }}</div>
                                <div class="cell">@{{ user.planning_res_err }}</div>
                                <div class="cell">@{{ user.ratios.planning_res_err }}</div>
                                <div class="cell">@{{ user.errh.planning_res_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Infrastructuring</div>
                                <div class="cell">@{{ res.Infrastructuring.res }}</div>
                                <div class="cell">@{{ user.infrastructuring_res_err }}</div>
                                <div class="cell">@{{ user.ratios.infrastructuring_res_err }}</div>
                                <div class="cell">@{{ user.errh.infrastructuring_res_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Coding </div>
                                <div class="cell">@{{ res.Coding.res }}</div>
                                <div class="cell">@{{ user.coding_res_err }}</div>
                                <div class="cell">@{{ user.ratios.coding_res_err }}</div>
                                <div class="cell">@{{ user.errh.coding_res_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Code review </div>
                                <div class="cell">@{{ res.Code_review.res }}</div>
                                <div class="cell">@{{ user.code_review_res_err }}</div>
                                <div class="cell">@{{ user.ratios.code_review_res_err }}</div>
                                <div class="cell">@{{ user.errh.code_review_res_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Compiling </div>
                                <div class="cell">@{{ res.Compiling.res }}</div>
                                <div class="cell">@{{ user.compiling_res_err }}</div>
                                <div class="cell">@{{ user.ratios.compiling_res_err }}</div>
                                <div class="cell">@{{ user.errh.compiling_res_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Testing </div>
                                <div class="cell">@{{ res.Testing.res }}</div>
                                <div class="cell">@{{ user.testing_res_err }}</div>
                                <div class="cell">@{{ user.ratios.testing_res_err }}</div>
                                <div class="cell">@{{ user.errh.testing_res_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Analysis </div>
                                <div class="cell">@{{ res.Analysis.res }}</div>
                                <div class="cell">@{{ user.analysis_res_err }}</div>
                                <div class="cell">@{{ user.ratios.analysis_res_err }}</div>
                                <div class="cell">@{{ user.errh.analysis_res_err }}</div>
                            </div>
                            <div class="psp-row">
                                <div class="cell"> Sum </div>
                                <div class="cell">@{{res.sum}}</div>
                                <div class="cell">@{{user.sum_res_err}}</div>
                                <div class="cell">100</div>
                                <div class="cell" id="sum_time_dev"></div>
                            </div>
                        </div>
                    </fieldset>
                </div>          
        </div>
</script>

<script type="text/x-handlebars-template" id="user-data-handle">
    @{{#each this}}
                <!-- Button to close the overlay navigation -->
                <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>

                <!-- Overlay content -->
                <div class="overlay-content">
                    <div id="info">
                        Name: @{{email}}
                        <br/>
                        Number: @{{psp_number}}
    </div>
    <div id="data">
                <fieldset>
                    <legend>Summary</legend>
                    <div class="table">
                        <div class="psp-row header">
                                            <div class="cell">
                                                
                                            </div>
                                            <div class="cell">
                                                Till now:
                                            </div>
                                            
                                        </div>
                        <div class="psp-row">
                            <div class="cell"> Min/LOC: </div><div class="cell">@{{minloc}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> LOC/hour:</div> <div class="cell">@{{loch}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> # of mistakes/KLOC: </div><div class="cell">@{{miskloc}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Ratio of fixing mistakes: </div><div class="cell">@{{ratio}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Searching/Fixing mistakes ratio: </div><div class="cell">@{{sfratio}}</div>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <legend>Size (Line of codes)</legend>
                    <div class="table">
                        <div class="psp-row header">
                            <div class="cell">
                                
                            </div>
                            <div class="cell">
                                Till now:
                            </div>
                                            
                        </div>
                        <div class="psp-row">
                            <div class="cell">Size(LOC):</div> <div class="cell">@{{size}}</div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Development time (min)</legend>
                    <div class="table">
                        <div class="psp-row header">
                            <div class="cell">
                                
                            </div>
                            <div class="cell">
                                Till now:
                            </div>
                            <div class="cell">
                                Ratio (%):
                            </div>
                                            
                        </div>
                        <div class="psp-row">
                            <div class="cell">Planing </div><div class="cell">@{{planning_time}}</div><div class="cell">@{{ratios.planning_time}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Infrastructuring</div> <div class="cell">@{{infrastructuring_time}}</div><div class="cell">@{{ratios.infrastructuring_time}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Coding </div><div class="cell">@{{coding_time}}</div><div class="cell">@{{ratios.coding_time}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Code review </div><div class="cell">@{{code_review_time}}</div><div class="cell">@{{ratios.code_review_time}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Compiling </div><div class="cell">@{{compiling_time}}</div><div class="cell">@{{ratios.compiling_time}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Testing </div><div class="cell">@{{testing_time}}</div><div class="cell">@{{ratios.testing_time}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Analysis </div><div class="cell">@{{analysis_time}}</div><div class="cell">@{{ratios.analysis_time}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Sum </div><div class="cell">@{{sum_time}}</div><div class="cell">100</div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Insert errors</legend>
                    <div class="table">
                        <div class="psp-row header">
                            <div class="cell">
                                
                            </div>
                            <div class="cell">
                                Till now:
                            </div>
                            <div class="cell">
                                Ratio (%):
                            </div>
                            <div class="cell">
                                Mistake per hour ratio:
                            </div>
                                            
                        </div>
                        <div class="psp-row">
                            <div class="cell">Planing </div><div class="cell">@{{planning_in_err}}</div><div class="cell">@{{ratios.planning_in_err}}</div><div class="cell">@{{errh.planning_in_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Infrastructuring</div> <div class="cell">@{{infrastructuring_in_err}}</div><div class="cell">@{{ratios.infrastructuring_in_err}}</div><div class="cell">@{{errh.infrastructuring_in_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Coding </div><div class="cell">@{{coding_in_err}}</div><div class="cell">@{{ratios.coding_in_err}}</div><div class="cell">@{{errh.coding_in_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Code review </div><div class="cell">@{{code_review_in_err}}</div><div class="cell">@{{ratios.code_review_in_err}}</div><div class="cell">@{{errh.code_review_in_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Compiling </div><div class="cell">@{{compiling_in_err}}</div><div class="cell">@{{ratios.compiling_in_err}}</div><div class="cell">@{{errh.compiling_in_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Testing </div><div class="cell">@{{testing_in_err}}</div><div class="cell">@{{ratios.testing_in_err}}</div><div class="cell">@{{errh.testing_in_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Analysis </div><div class="cell">@{{analysis_in_err}}</div><div class="cell">@{{ratios.analysis_in_err}}</div><div class="cell">@{{errh.analysis_in_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Sum </div><div class="cell">@{{sum_in_err}}</div><div class="cell">100</div><div class="cell"></div>
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend>Insert errors</legend>
                    <div class="table">
                        <div class="psp-row header">
                            <div class="cell">
                                
                            </div>
                            <div class="cell">
                                Till now:
                            </div>
                            <div class="cell">
                                Ratio (%):
                            </div>
                            <div class="cell">
                                Mistake per hour ratio:
                            </div>
                                            
                        </div>
                        <div class="psp-row">
                            <div class="cell">Planing </div><div class="cell">@{{planning_res_err}}</div><div class="cell">@{{ratios.planning_res_err}}</div><div class="cell">@{{errh.planning_res_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Infrastructuring</div> <div class="cell">@{{infrastructuring_res_err}}</div><div class="cell">@{{ratios.infrastructuring_res_err}}</div><div class="cell">@{{errh.infrastructuring_res_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Coding </div><div class="cell">@{{coding_res_err}}</div><div class="cell">@{{ratios.coding_res_err}}</div><div class="cell">@{{errh.coding_res_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Code review </div><div class="cell">@{{code_review_res_err}}</div><div class="cell">@{{ratios.code_review_res_err}}</div><div class="cell">@{{errh.code_review_res_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Compiling </div><div class="cell">@{{compiling_res_err}}</div><div class="cell">@{{ratios.compiling_res_err}}</div><div class="cell">@{{errh.compiling_res_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Testing </div><div class="cell">@{{testing_res_err}}</div><div class="cell">@{{ratios.testing_res_err}}</div><div class="cell">@{{errh.testing_res_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Analysis </div><div class="cell">@{{analysis_res_err}}</div><div class="cell">@{{ratios.analysis_res_err}}</div><div class="cell">@{{errh.analysis_res_err}}</div>
                        </div>
                        <div class="psp-row">
                            <div class="cell"> Sum </div><div class="cell">@{{sum_res_err}}</div><div class="cell">100</div><div class="cell" id="sum_time_dev"></div>
                        </div>
                    </div>
                </fieldset>
            </div>
    </div>
    @{{/each}}
</script>

<script type="text/javascript" src="js/handlebars-v4.0.12.js"></script>
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/script.js"></script>
@endsection