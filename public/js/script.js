let testData;
const loggedUserId = document.getElementById("test").innerHTML;
let activeProjectId;
let activeOrganisationId;
let activeTask;
let projectsLeadersL = {};
const projectsLeaders ={};

window.onload = function(){
    init();

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

        initClickEvents();
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

    let element = $("#org"+id).parent();

    if (option == 1){
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

function initClickEvents(){
    let addProjectForms = $(".org-option-add-project");
    console.log(addProjectForms);
    $.each(addProjectForms, (index) => {
        addProjectForms[index].addEventListener("click", displayAddProjectForm);
    });
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

    hideAddOrganisationModal();
}

$("#btn-openOrganisationModal").click(openAddOrganisationModal);
$("#btn-addNewOrganisation").click(addOrganisation);
$(".project-users-list").click(testF);

function proOnClick(id){
    console.log(id);
}

function orgOnClick(orgId) {
    console.log(orgId);
}

function displayAddProjectForm(orgId, event){
    $("#org"+orgId+"-addProject_form").toggle(200);
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
    activeOrganisationId = orgId;
    sendRequest('/api/tasks/all', 'GET', {idProject: projectId}, function(result){
        console.log(result);
        drawProjectTasks(result);
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
    });
}

function getAvailableUsers(event){
    sendRequest('/api/tasks', 'GET', {idProject: activeProjectId, idTask:activeTask}, function(result){
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

    $('#taskInfo_user-dropdown').css('left',event.pageX + 'px' );
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
        console.log(result);
        getTaskInfo(activeTask);
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

function getUserPSPData() {
    sendRequest('/api/psp_user_data/5', 'GET', '', function (data) {
        let template = $("#user-data-handle").html();
        $("#navPSP").html(makeTemplate(template, data));
    });
}

function deleteProject(projectId) {
    /*
    sendRequest("/api/project/"+projectId, 'DELETE', '',function(result){
        console.log("Project deleted! v novi metodi");
        //refresh menu
        getUserOrganisations();
    });*/
    
    sendRequest("/api/projectsusers/"+ projectId +"/"+loggedUserId, 'DELETE', '', function(){
        console.log("You have been removed from this project.");
        //refresh menu
        getUserOrganisations();
    });
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

Handlebars.registerHelper("isMeLeader", function(idLeader, options){
    var fnTrue = options.fn, 
        fnFalse = options.inverse;
    console.log(idLeader+" == "+loggedUserId);
    return idLeader == loggedUserId ? fnTrue(this) : fnFalse(this);
});

Handlebars.registerHelper("isMeLeaderP", function(options){
    var fnTrue = options.fn, 
        fnFalse = options.inverse;
    
    return lastClickedProjectInMenu == loggedUserId ? fnTrue(this) : fnFalse(this);
});

Handlebars.registerHelper("saveProInfo", function(idProject, idLeader){
    projectsLeadersL[idProject] = idLeader;
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
    $("#sideMenu").hide(500);
}

btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.addEventListener("click", function(event){
    console.log(event.target);
    let dropdown = document.getElementById("taskInfo_user-dropdown");
    
    if ($("#taskInfo_user-dropdown").html() && !$.contains(dropdown, event.target)){
        $("#taskInfo_user-dropdown").remove();
    } else if (event.target == modal) {
        modal.style.display = "none";
    } else if(event.target.id === "navPSP") {
        closeNav();
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