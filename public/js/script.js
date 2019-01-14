let testData;
const loggedUserId = document.getElementById("test").innerHTML;
let activeProjectId;
let activeOrganisationId;
let activeTask;
let projectsLeadersL = {};
const projectsLeaders ={};
const orgLeaders = {};
let projectOrOrgClicked;

window.onload = function(){

    init();

    if (typeof(Storage) !== "undefined") {
        let history = JSON.parse(localStorage.getItem("history")); 
        console.log(history);
        if (history[loggedUserId]){
            activeProjectId = history[loggedUserId]["lastOpenedPro"];
            activeOrganisationId = history[loggedUserId]["lastOpenedOrg"];
            getProjectTasks(activeProjectId, activeOrganisationId);
        }
    } else {
        // Sorry! No Web Storage support..
    }

    function init() {
        getUserOrganisations();
        $('[data-toggle="tooltip"]').tooltip();
    }
}

function getUserOrganisations(){
    $.get("/api/userorganisationsprojects?idUser="+loggedUserId, function(data){
        console.log(data);
        
        let template = document.getElementById("side-menu-handle").innerHTML;

        document.getElementById("modal-body_organistaions").innerHTML = makeTemplate(template, data);
    });
}

let lastClickedProjectInMenu;
//option = 0 - organisation
// option = 1 - project
function getUsersOfOrgOrPro(id, option){
    let element;
    let data;
    if (option == 0) {
        console.log("users of organisation");
        sendRequest('/api/users', 'GET', {idOrganisation: id}, function(result){
            element = $("#org"+id);
            data = result;
            drawUserList(element, data);
        });
    } else {
        console.log("users of projects");
        sendRequest('/api/users', 'GET', {idProject: id}, function(result){
            element = $("#pro"+id);
            data = result;
            drawUserList(element, data);
        });
    }
}

function showUsers(id, option) {
    let element;
    if (option == 0){
        activeOrganisationId = id; 
        element = $("#org"+id).parent();
        projectOrOrgClicked = 0;
    } else if (option == 1){
        projectOrOrgClicked = 1;
        lastClickedProjectInMenu = id;
        element = $("#pro"+id).parent();
    }

    if ($(element).is(":hidden") || $(element).html() == ""){
        getUsersOfOrgOrPro(id, option);
    } else {
        element.hide(500);
    }
}

function drawUserList(element, data){
    let template = $("#menu-user-list-handle").html();
    let users = element.html(makeTemplate(template, data));
    element.parent().show(500);
}

// vrednost(email) dobi iz input fielda
function addUserToOrganisation(orgId) {
    let email = $("#org" + orgId + "_newUser").val();
    
    sendRequest("/api/user", 'GET', {userEmail: email}, function (result) {
        let userId = result["id"];
        sendRequest("/api/organisationsusers", 'POST', {idOrganisation: orgId, idUser: userId}, function(result){
            //refresh user's organisation list
            getUserOrganisations();
        });
    });
}

// vrednost(id) dobi iz input fielda
function addUserToProject(proId) {
    let newUser = $("#pro" + proId + "_newUser").val();
    sendRequest("/api/projectsusers", "POST", { idProject: proId, idUser: newUser }, function (result) {
        console.log("project assigned");
        showUsers(proId, 1);
    });
}

function testF(event){
    console.log(event.target);
}

function openAddOrganisationModal(){
    $("#addOrganisationModal").css("display", "block");
}

function hideAddOrganisationModal(){
    $("#addOrganisationModal").css("display", "none");
}

function addOrganisation(){
    console.log("here i am");
    let name = $("#addOrganisation-name").val();
    let desc = $("#addOrganisation-description").val();
    console.log(name+ "  " + desc);
    $.post("/api/organisation", {name: name, description: desc, idLeader: loggedUserId}, function(result){
        let lastOrgId = result;
        $.post("/api/organisationsusers", {idOrganisation: lastOrgId, idUser: loggedUserId}, function(result){
            //refresh user's organisation list
            getUserOrganisations();
        });
    });
    $("#addOrgForm").hide(500);
}

$("#btn-openOrganisationModal").click(function(){
    $("#addOrgForm").toggle(500);
});

$("#btn-addNewOrganisation").click(addOrganisation);
$(".project-users-list").click(testF);

function proOnClick(id){
    console.log(id);
}

function orgOnClick(orgId) {
    console.log(orgId);
}

function displayAddProjectForm(orgId){
    $("#org"+orgId+"-addProject_form").toggle(500);
}

function addProjectToOrganisation(orgId, event){
    console.log("ahooj");
    let parent = event.target.parentElement;
    let projectName = parent.children[0].value;
    let projectDesc = parent.children[1].value;

    sendRequest("/api/project", "POST", { idOrganisation: orgId, name: projectName, description: projectDesc, idLeader: loggedUserId}, function(result){
        let proId = result;
        console.log("project created, id : "+result);
        
        sendRequest("/api/projectsusers", "POST", {idProject: proId, idUser: loggedUserId}, function(result){
            console.log("project assigned");
            getUserOrganisations();
        });
    });
}

/*
function activateProject(projectId){
    activeProjectId = projectId;
    getProjectTasks(projectId);
}*/

function getProjectTasks(projectId, orgId){
    activeProjectId = projectId;

    if (orgId)
        activeOrganisationId = orgId;

    let saveTostorage = {};
    saveTostorage[loggedUserId] = {lastOpenedOrg: activeOrganisationId, lastOpenedPro: activeProjectId};

    window.localStorage.setItem("history", JSON.stringify(saveTostorage));

    console.log("get project tasks");
    console.log("pro id: "+ activeProjectId);
    console.log("org id: "+ activeOrganisationId);

    sendRequest('/api/tasks/all', 'GET', {idProject: projectId, idUser: loggedUserId}, function(result){
        console.log(result);
        drawProjectTasks(result);
        hideSideMenu();
    });
}

function drawProjectTasks(data){
    let template = $("#project-tasks-handle").html();
    $("#project-tasks").html(makeTemplate(template, data));
    hideAddOrganisationModal();
}

// parameter(stevilka) pove status taska (OPEN, CLOSED, ..)
// ostevilceni so isto kot v bazi 1 - OPEN, 2 - CLOSED, 3 - IN PROGRESS, 4 - REVIEW, 5 - REJECTED
function addTaskToProject(taskStatus){
    let taskName = $("#task_name_"+taskStatus).val();
    sendRequest('/api/task', 'POST', {idProject: activeProjectId, name: taskName, status: taskStatus}, function(result){
        //hide add task form
          //TODO

        console.log("projektu "+activeProjectId+" doda task s statusom "+taskStatus);

        //refresh tasks
        getProjectTasks(activeProjectId, activeOrganisationId);
    });
}

function showAddTaskForm(statusId){
    $("#add-task-form_"+statusId).toggle(500);
}

function changeTaskStatus(taskId, status){

    // ce je task id 0 pomeni, da to funkcijo klicemo iz tasikInfo modal-a
    // kar pomeni da je globalna spremenljivka nastavljena na trenuten task
    if (taskId == 0)
        taskId = activeTask;

    sendRequest('/api/taskstatus', 'POST', {taskId: taskId, status: status}, function(result){
        console.log("task's with id "+taskId+" changed to "+status);
        getProjectTasks(activeProjectId);
        if (!$("#taskInfo").is(":hidden"))
            getTaskInfo(activeTask);
    });
}

function getTaskInfo(taskId) {
    console.log("display task "+taskId);
    sendRequest('/api/task/'+taskId, 'GET', '', function(result){
        console.log(result);
        showTaskInfo(result);
    });
}

function updateTaskName(){
    let newName = $("#taskInfo_name").val();
    sendRequest('/api/task/'+activeTask, 'POST', {name: newName, description: ""}, function(){
        $("#task_name-taks_"+activeTask).html(newName);
    });
}

function updateTaskDescription(){
    let newDesc = $("#task-description-text").val();
    sendRequest('/api/task/'+activeTask, 'POST', {description: newDesc, name: ""}, function(){});
}

function showTaskInfo(data) {
    activeTask = data["id"];
    console.log(data);

    $("#taskInfo_name").val(data["name"]);
    $("#task-description-text").val(data["description"]);

    let header = $(document.querySelector("#taskInfo .modal-header")),
        header_input = $("#taskInfo_name"),
        body = $(document.querySelector("#taskInfo .modal-body")),
        textarea = $("#task-description-text");

    let taskStatus = data["idTask_status"];
    let color = "#344E5C"; // open
    if (taskStatus == 2) {color = "#4AB19D";}
    else if (taskStatus == 3) {color = "#EFC958";}
    else if (taskStatus == 4) {color = "#E17A47";}
    else if (taskStatus == 5) {color = "#EF3D59";}

    header.css("background-color", color);

    header_input.css("background-color", color);
    header_input.css("border-color", color);

    body.css("background-color", color);

    textarea.css("background-color", color);
    textarea.css("border-color", color);

    showTaskInfo_users(data["users"]);
    
    $("#taskInfo").show();
}

function showTaskInfo_users(users) {
    let template = $("#taskInfo-user-list-handle").html();
    $("#taskInfo_modal-footer").html(makeTemplate(template, users));
}

function removeUserFromTask(idUser, event) {
    sendRequest('/api/tasksusers/'+idUser+'/'+activeTask, 'DELETE', '', function(result){
        // odstranim div z userjem, namesto še enkrat narisat modal
        let userDiv = event.target.parentElement.parentElement;
        let userDivParent = userDiv.parentElement;
        userDivParent.removeChild(userDiv);

        getProjectTasks(activeProjectId);
    });
}

function deleteTask(idTask) {
    sendRequest('/api/task/'+idTask, 'DELETE', '', function(result){
        //refresh tasks
        getProjectTasks(activeProjectId, activeOrganisationId);
    })
}

function getAvailableUsers(event, idTask){
    
    if (idTask == 0)
        idTask = activeTask;
    else
        activeTask = idTask;

    sendRequest('/api/tasks', 'GET', {idProject: activeProjectId, idTask:idTask}, function(result){
        console.log(result);
        showAvailableUsers(event, result); 
    });
}

function showAvailableUsers(event, data){
    //create this div
    let userDropdown = document.createElement("div");
    userDropdown.id = "taskInfo_user-dropdown";

    let template = $("#taskInfo-add_user-list-handle").html();
    userDropdown.innerHTML = makeTemplate(template, data);
    $("#wrapper").append(userDropdown);

    let left = event.pageX;
    if (left < 160)
        left = 160;

    $('#taskInfo_user-dropdown').css('left',left + 'px' );
    $('#taskInfo_user-dropdown').css('top',event.pageY + 'px' );
    
}

function addUserToTask(idUser, event) {
    console.log('adding user '+idUser+' to task '+activeTask);
    sendRequest('/api/tasksusers', 'POST', {idTask: activeTask, idUser: idUser, idPSP: 1}, function(result){
        //odstranimo kliknjen div
        let userToRemove = event.target.parentElement.parentElement;
        let userToRemove_parent = userToRemove.parentElement;
        userToRemove_parent.removeChild(userToRemove);
        //refreshamo taskInfo modal
        if (!$("#taskInfo").is(":hidden"))
            getTaskInfo(activeTask);

        //refreshamo taske
        getProjectTasks(activeProjectId);
    });
}

/* PSP STUFF!!!!!!!!!!!!!!!!!!!!!!!!! */
function openNav() {
    document.getElementById("navPSP").style.display = "block";
}

/* Close when someone clicks on the "x" symbol inside the overlay */
function closeNav() {
    document.getElementById("navPSP").style.display= "none";
}

function getPSPData(idTask) {
    sendRequest('/api/pspdata/'+loggedUserId+'/'+idTask, 'GET', '', function (data) {
        console.log(data);
        let template = $("#psp-data-handle").html();
        $("#navPSP").html(makeTemplate(template, data));
        openNav();
    });
}

function getUserPSPData(idUser) {

    if (idUser == 0)
        idUser = loggedUserId;

    sendRequest('api/update_psp_data/'+idUser, 'POST', '',function(){
        sendRequest('/api/psp_user_data/'+idUser, 'GET', '', function (data) {
            console.log(data);
            let template = $("#user-data-handle").html();
            $("#navPSP").html(makeTemplate(template, data));
            openNav();
        });
    });
}

function updatePLanguage(idPSP) {
    prog_lang = $("#prog_language").val();
    console.log($("#prog_language").val());
    sendRequest('/api/psp/' + idPSP, 'POST', { programing_language: prog_lang}, function(result) {
        });
}

/* PSP TASKS STUFF!!!! */
function openPSPTasksNav(idTask) {
    document.getElementById("navPSP-tasks").style.display = "block";
    //$("#navPSP-tasks").show();
}

function closePSPTasksNav() {
    $("#navPSP-tasks").hide();
}

function getPSPTaskData(idTask){
    activeTask = idTask;
    sendRequest('/api/psptasks/'+loggedUserId+'/'+idTask, 'GET', '', function(result){
        console.log(result);
        let template = $("#tasks-PSP-handle").html()
        $("#tasks-record-list").html(makeTemplate(template, result));
        openPSPTasksNav();
    });
}

function addPSPTask(){
    let idPhase = $("#idPhase").val();
    let startDate = $("#startDate").val();
    let startTime = $("#startTime").val();
    let endDate = $("#endDate").val();
    let endTime = $("#endTime").val();
    let pause = $("#pause").val();
    let description = $("#description").val();
    let estimatedtime = $("#estimatedtime").val();
    let estimatedunits = $("#estimatedunits").val();
    let units = $("#units").val();
    console.log(startDate);
    console.log(startTime);
    let start = null;
    if (startDate != null){
        start = new Date(startDate + " " + startTime);
        start = start.toISOString().slice(0, 19).replace('T', ' ');
        console.log(start);
    }
    
    let end = null;
    if (endDate != null)
        end = new Date(endDate + " " + endTime).toISOString().slice(0, 19).replace('T', ' ');

    sendRequest('/api/psptask', 'POST', {idPhase: idPhase, idUser: loggedUserId, idTask: activeTask, start:start, end:end, pause, description: description, units: units, estimatedtime: estimatedtime, estimatedunits: estimatedunits}, function(result){
        console.log(result);
        //refresh table
        getPSPTaskData(activeTask);
    });
}

function deletePSPTaskRecord(idRecord){
    sendRequest('/api/psptask/'+idRecord, 'DELETE', '', function(result){
        getPSPTaskData(activeTask);
    });
}

function showPSPTaskRecord(id){

    //scrolla na zacetek, da vidimo vrednosti
    let el = document.querySelector("#navPSP-tasks .modal-body")
    el.scrollTo(0, 0);

    $("#idPhase").val($("#record_phaseid_"+id).html());
    $("#startDate").val($("#record_startDate_"+id).html());
    $("#startTime").val($("#record_startTime_"+id).html());
    $("#endDate").val($("#record_endDate_"+id).html());
    $("#endTime").val($("#record_endTime_"+id).html());
    $("#pause").val($("#record_pause_"+id).html());
    $("#description").html($("#record_description_"+id).html());
    $("#estimatedtime").val($("#record_estimatedtime_"+id).html());
    $("#estimatedunits").val($("#record_estimatedunits_"+id).html());
    $("#units").val($("#record_units_"+id).html());
}


/* PSP MISTAKES STUFF!!!!!!!!!!!!! */

function openPSPMistakes(){
    document.getElementById("navPSPError").style.display = "block";
}
function closePSPMistakes(){
    document.getElementById("navPSPError").style.display = "none";
}

function getPSPMistakes(idTask){
    activeTask = idTask;
    sendRequest('/api/psperrors/'+loggedUserId+'/'+idTask, 'GET', '', function(result){
        console.log(result);
        let template = $("#error-PSP-handle").html();
        $("#error-list").html(makeTemplate(template, result));
        openPSPMistakes();
    })
}

function addPSPError(){
    let phaseEntry = $("#phaseEntry").val();
    let phaseFinish = $("#phaseFinish").val();
    let category = $("#category").val();
    let resolve_time = $("#resolve_time").val();
    let num_fixed_errors = $("#num_fixed_errors").val();
    let description = $("#error_description").val();
    console.log(description);

    sendRequest('/api/psperror', 'POST', {idUser: loggedUserId, idTask: activeTask, phaseEntry:phaseEntry, phaseFinish: phaseFinish, idCategory: category, resolve_time: resolve_time, num_fixed_errors:num_fixed_errors, description : description}, function(result){
       getPSPMistakes(activeTask);
    });

    $("#phaseEntry").val(null);
    $("#phaseFinish").val(null);
    $("#category").val(null);
    $("#resolve_time").val(null);
    $("#num_fixed_errors").val(null);
    $("#error_description").val(null);
}

function deletePSPErrorRecord(idRecord) {
    sendRequest('/api/psperror/'+idRecord, 'DELETE', '', function(result){
        getPSPMistakes(activeTask);
    });
}

function showPSPErrorRecord(id) {

    //scrolla na zacetek, da vidimo vrednosti
    let el = document.querySelector("#navPSPError .modal-body");
    el.scrollTo(0, 0);

    $("#phaseEntry").val($("#record_pIdEntry_"+id).html());
    $("#phaseFinish").val($("#record_pIdFinish_"+id).html());
    $("#category").val($("#record_idCategory_"+id).html());
    $("#resolve_time").val($("#record_resolve_time_"+id).html());
    $("#num_fixed_errors").val($("#record_num_fixed_errors_"+id).html());
    $("#error_description").html($("#record_description_"+id).html());
}

function deleteProject(projectId) {
    
    sendRequest("/api/project/"+projectId, 'DELETE', '',function(result){
        console.log("Project deleted! v novi metodi");
        //refresh menu
        getUserOrganisations();
    });
    /*
    sendRequest("/api/projectsusers/"+ projectId +"/"+loggedUserId, 'DELETE', '', function(){
        console.log("You have been removed from this project.");
        //refresh menu
        getUserOrganisations();
    });*/
}

function deleteOrganisation(orgId){
    sendRequest('/api/organisation/'+orgId, 'DELETE', '', function(result){
        console("organisation deleted!");
        //refresh menu
        getUserOrganisations();
    });
}

function showOrgUsers(orgId){
    sendRequest('/api/users', 'GET', {idOrganisation: orgId}, function(result){
        console.log(result)
    });
}

function removeUserFromProject(userId, event) {
    sendRequest('/api/projectsusers/'+lastClickedProjectInMenu+'/'+userId, 'DELETE', '', function(result){
        console.log("user: "+userId+" was removed from project "+lastClickedProjectInMenu);
        let row_parent = event.target.parentElement.parentElement.parentElement.parentElement;
        let row_to_delete = event.target.parentElement.parentElement.parentElement;
        row_parent.removeChild(row_to_delete);
    });
}

//Handlebar helper to check if the user in project is the user that is logged in
Handlebars.registerHelper("isMe", function(userId, options){
    var fnTrue = options.fn, 
        fnFalse = options.inverse;

    return userId == loggedUserId ? fnTrue(this) : fnFalse(this);
});

Handlebars.registerHelper("isMeLeader", function(options){
    var fnTrue = options.fn, 
        fnFalse = options.inverse;

        let compare = projectOrOrgClicked == 0 ? orgLeaders[activeOrganisationId] : projectsLeaders[lastClickedProjectInMenu]

        return compare == loggedUserId ? fnTrue(this) : fnFalse(this);
        
});

Handlebars.registerHelper("isMeLeaderPO", function(idLeader, options){
    var fnTrue = options.fn, 
        fnFalse = options.inverse;
    
    return idLeader == loggedUserId ? fnTrue(this) : fnFalse(this);
});

Handlebars.registerHelper("saveProInfo", function(idProject, idLeader){
    projectsLeaders[idProject] = idLeader;
});

Handlebars.registerHelper("saveOrgInfo", function(idOrganisation, idLeader){
    orgLeaders[idOrganisation] = idLeader;
});

Handlebars.registerHelper("hasTaskAccess", function(access, options){
    var fnTrue = options.fn, 
        fnFalse = options.inverse;

    if (access)
        return fnTrue(this);
    return fnFalse(this);
});

function sendRequest(url, type, data, callback) {
    $.ajax({
        url: url,
        type: type,
        data: data,
        success: callback,
        error: function(error){
            console.log(error);
        }
    });
}

function makeTemplate(template, data){
    let compiledTemplate = Handlebars.compile(template);
    return compiledTemplate(data);
}

// Get the modal
var modal = document.getElementById('sideMenu');

// Get the button that opens the modal
var btn = document.getElementById("btn-openSideMenu");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal 
function showSideMenu(){
    $("#sideMenu").show(500);
}

function hideSideMenu(){
    $("#sideMenu").hide(500);
}

btn.onclick = function() {
    showSideMenu();
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    hideSideMenu();
}

// When the user clicks anywhere outside of the modal, close it
window.addEventListener("click", function(event){
    let dropdown = document.getElementById("taskInfo_user-dropdown");
    
    if ($("#taskInfo_user-dropdown").html() && !$.contains(dropdown, event.target)){
        $("#taskInfo_user-dropdown").remove();
    } else if (event.target == modal) {
        hideSideMenu()
    } else if(event.target.id === "navPSPError"){
        closePSPMistakes();
    } else if(event.target.id === "navPSP") {
        closeNav();
    } else if(event.target.id === "navPSP-tasks") {
        closePSPTasksNav();
    } else if(event.target.id === "taskInfo") {
        $("#taskInfo").hide();
    }
}, true);

$("#joke").hover(function(){
    $("#joke").html("Klikni me!");
}, function(){
    $("#joke").html("STOPAR!");
});

$("#joke").click(function(){
    window.open("https://www.youtube.com/watch?v=DVx8L7a3MuE");
});

