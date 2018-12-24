let testData;
let loggedUserId = document.getElementById("test").innerHTML;
window.onload = function(){
    init();

    function init() {
        getUserOrganisations();
    }
	
	function getUserOrganisations(){
		$.get("/api/organisations?idUser="+loggedUserId, function(data){
			
            for (let i = 0; i < data.length; i++){
                data[i]["projects"] = [];
                $.get("/api/projects?idUser="+loggedUserId+"&idOrganisation="+data[i]["idOrganisation"]+"", function(projectData){
                    console.log("Project data : ");
                    console.log(projectData);
                    data[i]["projects"].push(projectData);
                });
            }

            window.setTimeout(function(){
                console.log(data); 
                testData = data;
                let rawTemplate = 
                "{{#each this}}" +
                    "<div class='org-list'>" +
                        "<div class='org'> {{idOrganisation}} : {{name}}" +
                            "<div class='projects-list'>" +
                                "<div>Projects</div>" +
                                "{{#each projects}}" +
                                    "{{#each this}}" +
                                        "<div class='pro'> {{id}} : {{name}} </div>" +
                                    "{{/each}}" +
                                "{{/each}}" +
                            "</div>" +
                        "</div>" +
                    "</div>" +
                "{{/each}}";
                console.log(rawTemplate);
                let compiledTemplate = Handlebars.compile(rawTemplate);
                let generatedHTML = compiledTemplate(data);

                document.getElementById("modal-body_organistaions").innerHTML = generatedHTML;
            }, 500);
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

