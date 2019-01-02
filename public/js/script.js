let testData;
let loggedUserId = document.getElementById("test").innerHTML;

window.onload = function(){
    init();

    function init() {
        getUserOrganisations();
    }
}

function getUserOrganisations(){
    $.get("/api/userorganisationsprojects?idUser="+loggedUserId, function(data){

        let rawTemplate = 
            "{{#each this}}" +
                "<div class='org-list'>" +
                    "<div class='org-container'>" +
                        "<div class='org-div'>" +
                            "<div class='org-name' onclick='orgOnClick({{idOrganisation}})'>{{orgName}}</div>" +
                            "<div class='org-options'>" +
                                "<div class='org-option-add-project'>+</div>" +
                                "<div class='org-option-remove'>-</div>" +
                                "<div class='add-project-div'>" +
                                    "<input type='text' placeholder='Name'>" +
                                    "<input type='text' placeholder='Description'>" +
                                    "<div class='small-btn' onclick='addProjectToOrganisation({{idOrganisation}}, event)'> Add </div>" +
                                "</div>" + 
                            "</div>" +
                        "</div>" +
                        "<div class='projects-list'>" +
                            "{{#each this}}" +
                                "{{#if idProject}}" +
                                    "<div class='pro-div'>" +
                                        "<div class='project-name'>{{pName}}</div>" +
                                        "<div class='pro-options'>" +
                                            "<div class='del-project' onclick='deleteProject({{idProject}})'>-</div>" +
                                        "</div>" +
                                    "</div>" +
                                "{{/if}}" +
                            "{{/each}}" +
                        "</div>" +
                    "</div>" +
                "</div>" +
            "{{/each}}";
        let compiledTemplate = Handlebars.compile(rawTemplate);
        let generatedHTML = compiledTemplate(data);

        document.getElementById("modal-body_organistaions").innerHTML = generatedHTML;

        initClickEvents();
    });
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
    $.post("/api/organisation", {name: name, description: desc}, function(result){
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

function proOnClick(id){
    console.log(id);
}

function orgOnClick(orgId) {
    console.log(orgId);
}

function displayAddProjectForm(event) {
    console.log("i am here");
    let addProjectForm = event.target.parentElement.lastChild;
    if (addProjectForm.classList.contains("collapsed")) {
        addProjectForm.classList.remove("collapsed");
    } else {
        addProjectForm.classList.add("collapsed");
    }
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

function deleteProject(projectId){
    sendRequest("/api/project/"+projectId, 'DELETE', '',function(result){
        console.log("Project deleted! v novi metodi");
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

function sendRequest(url, type, data, callback) {
    console.log("pica");
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

// Get the modal
var modal = document.getElementById('sideMenu');

// Get the button that opens the modal
var btn = document.getElementById("btn-openSideMenu");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
