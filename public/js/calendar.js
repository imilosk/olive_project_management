function Calendar (parentElement, events){
	
	this.dateObject = new Date();
	this.year = this.dateObject.getFullYear();
	this.daysNames = ["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
	this.daysNamesToDraw = ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"];
	this.monthsNames = ["January", "February", "March", "April", "May", 
				 "June", "July", "August", "September", "October", "November", "December"];
	this.activeMonth = this.dateObject.getMonth();
	this.day = this.dateObject.getDate();
	this.dayInWeek = this.dateObject.getDay();
	this.dayName = this.daysNames[this.dateObject.getDay()];
	
	let yearr = this.year;
	let currentMonthh;
	let daysNamess = this.daysNames;
	let monthsNamess = this.monthsNames;
	let dayNamee = this.dayName;
	let activeDay = this.day;
	let activeMonthh = this.activeMonthh;
	let clickedDay;
	let choosenExercises = [];
	let createdExercises = {};
	let exercisesContainer = document.getElementById("exercises");
	let exercises = [];
	let canMakeExercise = true;
	let newWorkout = {};
	let clickedElement;

	let clockTimer;
	let workoutTime = 0;
	let mainTimer;
	let timer;
	let interval;
	let mainInterval;
	let tempForPausedMainTime;
	let tempForPausedTime;
	let currentExercise = 0;
	let currentRound = 0;
	let exerciseOption = "";
	let finishedExerciseButton;
	let audio;

	function startTime() {
    	var today = new Date();
    	var h = today.getHours();
    	var m = today.getMinutes();
    	m = checkTime(m);
    	document.getElementById("modal-clock-hours").innerHTML = h;
    	document.getElementById("modal-clock-minutes").innerHTML = m;
    	clockTimer = setTimeout(startTime, 500);
	}

	function checkTime(i) {
	    if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
	    return i;
	}

	drawTimeIcon = function(time) {
		let div = document.createElement('div');
		let start_time_img = document.createElement("img");
		start_time_img.src = "../../static/img/time.svg";
		start_time_img.width = 20;
		start_time_img.height = 20;

		div.appendChild(start_time_img);

		start_time_text = document.createElement('div');
		start_time_text.innerHTML = time;
		start_time_text.classList.add("timeDiv");

		div.appendChild(start_time_text);

		return div;
	}

	removeWorkout = function(event) {

		if (logedIn && data[currentMonthh][clickedDay]["WorkoutID"] != 0)
			removeWorkoutFromDatabase(data[currentMonthh][clickedDay]["WorkoutID"]);

		data[currentMonthh][clickedDay] = undefined;
		clickedElement.lastChild.innerHTML = "";
		displayWorkoutModal(document.getElementById("modal-date-dayName").innerHTML, clickedDay);

	}

	test = function(event) {
		let target = event.target;
		while (true){
			if (!target.classList.contains("exercise")){
				target = target.parentElement;
			} else {
				break;
			}
		}
		let index_str = target.children[0].innerHTML;
		let index_int = parseInt(index_str.substring(0, index_str.length-1)) - 1;
		console.log(data[currentMonthh][clickedDay]["WorkoutExercises"][index_int]);
		deleteExercise(data[currentMonthh][clickedDay]["WorkoutExercises"][index_int]["ID"]);
		displayWorkoutModal(document.getElementById("modal-date-dayName").innerHTML, document.getElementById("modal-date-day").innerHTML);
	}

	displayWorkoutModal = function(dayName, dayN) {

		document.getElementById("modal-date-dayName").innerHTML = dayName;
    	document.getElementById("modal-date-day").innerHTML = dayN+"."
    	document.getElementById("modal-date-month").innerHTML = monthsNamess[currentMonthh];

    	document.getElementById("save-workout").style.display = "table-cell";

    	if (!checkLogged()) {
    		document.getElementById("save-workout").style.display = "none";
    	}

    	// ura
    	startTime();

    	let choosen_exercises_div = document.getElementById("choosen-exercises"); // exercises = chosenExercises that were saved in table 
    	
		if (data[currentMonthh] != undefined && data[currentMonthh][clickedDay] != undefined) { 
			choosenExercises = data[currentMonthh][clickedDay]["WorkoutExercises"];
			
			exercises = choosenExercises;
			
			document.getElementById("Time").value = data[currentMonthh][clickedDay]["Time"];

			exercisesContainer.innerHTML = "";

			// makes and draw exercises
			drawExercises();

			document.getElementById("n-rounds").value = data[currentMonthh][clickedDay]["Rounds"];

			//rest between exercise and rounds
			document.getElementById("r_between_e").value = data[currentMonthh][clickedDay]["r_between_e"];
			document.getElementById("r_between_r").value = data[currentMonthh][clickedDay]["r_between_r"];


			document.getElementById("workoutOverlay").style.height = "100%";
    		document.getElementById("workoutOverlayInner").style.height = "auto";
		} else {
			document.getElementById("Time").value = "";
			document.getElementById("r_between_e").value = "0";
   			document.getElementById("r_between_r").value = "0";
   			document.getElementById("n-rounds").value = "0";
   			document.getElementById("exercises").innerHTML = "";

			createNewWorkout();

			let timeDiv = drawTimeIcon(data[currentMonthh][dayN]["Time"]);
   			clickedElement.lastChild.appendChild(timeDiv);
		}

		if (data[currentMonthh][clickedDay]["Completed"] == 1){
			displayFinishElements();
		} else {
			if (currentMonthh != (new Date()).getMonth() | dayN != activeDay) {
				displayCantWorkoutElements();
    		} else {
    			displayWorkoutElements();
    		}
		}

    	//display
    	document.getElementById("workoutOverlay").style.height = "100%";
    	document.getElementById("workoutOverlayInner").style.height = "auto";
	}

	startTimer = function(duration) {
    	timer = duration;
    	let minutes;
    	let seconds;
    
    	interval = setInterval(function () {
		    minutes = parseInt(timer / 60, 10);
		    seconds = parseInt(timer % 60, 10);

		    minutes = minutes < 10 ? "0" + minutes : minutes;
		    seconds = seconds < 10 ? "0" + seconds : seconds;

		    document.getElementById("timer").innerHTML = minutes + ":" + seconds;

		    if (exerciseOption == "Sec" && (timer <= 5 && timer > 0)){
		    	playAudio('../../static/sound/beep.mp3');
		    }

		    timer--;

		    if (timer < 0) {
		    	if (exerciseOption == "Reps"){
		    		document.getElementById("finish-exercise-button").style.display = "block";
		    		document.getElementById("timer").style.display = "none";
		    		clearInterval(interval);
		    	} else if (exerciseOption == "Sec"){
		    		playAudio('../../static/sound/bleep.mp3');
		    		clearInterval(interval);
		    		document.getElementById("finish-exercise-button").style.display = "block";
		    		document.getElementById("timer").style.display = "none";
		    	} else if (exerciseOption == "Ready") {
		    		document.getElementById("exercise-narrator-e-name").innerHTML = data[currentMonthh][clickedDay]["WorkoutExercises"][currentExercise]["DOMnode"].children[1].innerHTML;
					document.getElementById("exercise-narrator-e-prop").innerHTML = data[currentMonthh][clickedDay]["WorkoutExercises"][currentExercise]["DOMnode"].children[2].innerHTML;
		
					if (data[currentMonthh][clickedDay]["WorkoutExercises"][currentExercise]["duration"] == 0){
						exerciseOption = "Reps";
						document.getElementById("finish-exercise-button").style.display = "block";
		    			document.getElementById("timer").style.display = "none";
		    			clearInterval(interval);
					} else{
						clearInterval(interval);
						startTimer(data[currentMonthh][clickedDay]["WorkoutExercises"][currentExercise]["duration"]);
						exerciseOption = "Sec";
					}
		    	} else if (exerciseOption = "Pause"){
		    		clearInterval(interval);
		    		initCurrentExerciseToDisplay();
		    	} else if (exerciseOption == "Round") {
		    		clearInterval(interval);
		    		initCurrentExerciseToDisplay();
		    	}
		    }

    	}, 1000);
	}

	playAudio = function(url) {
        audio = new Audio(url);
		audio.play();
    }

	startMainTimer = function (timer) {
		mainTimer = timer;
		var minutes = 0;
		var seconds = 0;

		mainInterval = setInterval(function () {
		    minutes = parseInt(mainTimer / 60, 10);
		    seconds = parseInt(mainTimer % 60, 10);

		    minutes = minutes < 10 ? "0" + minutes : minutes;
		    seconds = seconds < 10 ? "0" + seconds : seconds;

		    document.getElementById("time-elapsed").innerHTML = minutes + ":" + seconds;

		    mainTimer++;

    	}, 1000);
	}

	startTimers = function (duration) {
        startMainTimer(0);
    	startTimer(duration);
	}

	stopTimers = function (duration) {
        clearInterval(mainInterval);
        clearInterval(interval);

        tempForPausedMainTime = mainTimer;
        tempForPausedTime = timer;
	}

	pauseWorkoutt = function(event) {

		stopTimers();

		event.target.classList.remove("fa-pause");
		event.target.classList.add("fa-play");
		event.target.removeEventListener("click", pauseWorkoutt);
		event.target.addEventListener("click", resumeWorkout, false);
	}

	resumeWorkout = function(event) {

		startMainTimer(tempForPausedMainTime);
		startTimer(tempForPausedTime);

		event.target.classList.remove("fa-play");
		event.target.classList.add("fa-pause");
		event.target.removeEventListener("click", resumeWorkout);
		event.target.addEventListener("click", pauseWorkoutt, false);
	}

	prepareWorkout = function () {
		if (document.getElementById("exercises").children.length != 0 && canMakeExercise) {
			let startDelay = 1;
			let timeBetweenExercises = data[currentMonthh][clickedDay]["r_between_e"];
			let timeBetweenRounds = data[currentMonthh][clickedDay]["r_between_r"];
			let numberOfRounds = data[currentMonthh][clickedDay]["Rounds"];

			let times = [timeBetweenExercises, timeBetweenRounds, numberOfRounds];

			document.getElementById("start-workout_div").style.display = "none";
			
			let rightModal = document.getElementById("modal-content-right");
			let workoutControl = document.createElement("div");
			workoutControl.id = "workout-control";

			let elapsedTime_div = document.createElement("div");
			elapsedTime_div.id = "elapsed-time-div";

			let elapsedTime_div_text = document.createElement("div");
			elapsedTime_div_text.innerHTML = "Elapsed Time";

			let timeElapsed = document.createElement("div");
			timeElapsed.id = "time-elapsed";
			timeElapsed.innerHTML = "00:00";

			elapsedTime_div.appendChild(elapsedTime_div_text);
			elapsedTime_div.appendChild(timeElapsed);

			let pauseWorkout = document.createElement("i");
			pauseWorkout.id = "pause-workout";
			pauseWorkout.className = pauseWorkout.className + " fa fa-pause animated-05";
			pauseWorkout.addEventListener("click", pauseWorkoutt, false);

			workoutControl.appendChild(elapsedTime_div);
			workoutControl.appendChild(pauseWorkout);
			rightModal.appendChild(workoutControl);

			let workoutArea = document.createElement("div");
			workoutArea.id = "workout-area";

			let exerciseNarrator = document.createElement("div");
			exerciseNarrator.id = "exercise-narrator";

			let exerciseNarrator_exerciseName = document.createElement("div");
			exerciseNarrator_exerciseName.id = "exercise-narrator-e-name";

			let exerciseNarrator_exerciseProp = document.createElement("div");
			exerciseNarrator_exerciseProp.id = "exercise-narrator-e-prop";

			exerciseNarrator.appendChild(exerciseNarrator_exerciseName);
			exerciseNarrator.appendChild(exerciseNarrator_exerciseProp);

			workoutArea.appendChild(exerciseNarrator);

			let timer = document.createElement("div");
			timer.id = "timer";

			let finishedExerciseButton = document.createElement("div");
			finishedExerciseButton.id = "finish-exercise-button";
			finishedExerciseButton.style.display = "none";
			finishedExerciseButton.innerHTML = "TAP WHEN DONE";
			finishedExerciseButton.addEventListener("click", nextExercise, false);

			workoutArea.appendChild(timer);
			workoutArea.appendChild(finishedExerciseButton);
			rightModal.appendChild(workoutArea);

			startWorkout();

		} else {
			displayMessageInWorkoutModal("You need to add atleast one exercise", 5);
		}

	}

	startWorkout = function () {
		if (document.getElementById("exercises").children.length != 0 && canMakeExercise) {
			startMainTimer(0);
			initCurrentExerciseToDisplay();
		} else {
			displayMessageInWorkoutModal("You need to add atleast one exercise");
		} 
		//startTimers(5);
		//data[currentMonthh][clickedDay]["WorkoutExercises"][i]["DOMnode"].style.border = "1px solid red";
	}

	initCurrentExerciseToDisplay = function () {
		document.getElementById("exercise-narrator-e-name").innerHTML = "Get Ready";
		document.getElementById("exercise-narrator-e-prop").innerHTML = "";
		exerciseOption = "Ready";
		data[currentMonthh][clickedDay]["WorkoutExercises"][currentExercise]["DOMnode"].classList.add("active-exercise");
		startTimer(5);
	}

	nextExercise = function () {
		data[currentMonthh][clickedDay]["WorkoutExercises"][currentExercise]["DOMnode"].classList.remove("active-exercise");
		let time;
		if (currentExercise == data[currentMonthh][clickedDay]["WorkoutExercises"].length-1){
			currentExercise = 0;
			currentRound++;
			console.log("next round");
			exerciseOption = "Round";
			time = data[currentMonthh][clickedDay]["r_between_r"];
		} else {
			currentExercise++;
			exerciseOption = "Pause";
			time = data[currentMonthh][clickedDay]["r_between_e"];
		}

		if (currentRound == data[currentMonthh][clickedDay]["Rounds"]){
			// over
			clearInterval(interval);
			clearInterval(mainInterval);

			data[currentMonthh][clickedDay]["Completed"] = 1;
			data[currentMonthh][clickedDay]["TimeToComplete"] = mainTimer;

			displayFinishElements();

			if (logedIn && data[currentMonthh][clickedDay]["ID"] != 0){
				saveCompletedWorkoutInfo(data[currentMonthh][clickedDay]["ID"], data[currentMonthh][clickedDay]["TimeToComplete"]);
			}

		} else {
			data[currentMonthh][clickedDay]["WorkoutExercises"][currentExercise]["DOMnode"].classList.add("active-exercise");

			document.getElementById("finish-exercise-button").style.display = "none";
			document.getElementById("timer").style.display = "block";

			document.getElementById("exercise-narrator-e-name").innerHTML = "Rest";
			document.getElementById("exercise-narrator-e-prop").innerHTML = "";

			startTimer(time);
		}
	}

	displayCantWorkoutElements = function () {
		let right_side_div = document.getElementById("modal-content-right");
		let right_side_div_title = right_side_div.children[0];
		right_side_div.innerHTML = "";
		right_side_div.appendChild(right_side_div_title);


		let message = document.createElement("div");
		message.id = "cant-workout-message";
		message.innerHTML = "This day is not today";

		right_side_div.appendChild(message);
	}

	displayWorkoutElements = function () {
		let right_side_div = document.getElementById("modal-content-right");
		let right_side_div_title = right_side_div.children[0];
		right_side_div.innerHTML = "";
		right_side_div.appendChild(right_side_div_title);

		let workout_start = document.createElement("div");
		workout_start.id = "start-workout_div";
		workout_start.addEventListener("click", prepareWorkout, false);
		workout_start.innerHTML = "Start Workout";

		right_side_div.appendChild(workout_start);
	}

	displayFinishElements = function () {
		let right_side_div = document.getElementById("modal-content-right");
		let right_side_div_title = right_side_div.children[0];
		right_side_div.innerHTML = "";
		right_side_div.appendChild(right_side_div_title);

		let finished_div = document.createElement("div");
		finished_div.id = "finished-information";

		let finished_div_title = document.createElement("div");
		finished_div_title.id = "finished-information-title";
		finished_div_title.innerHTML = "Workout Completed !";

		let finished_div_time = document.createElement("div");
		finished_div_time.id = "finished-information-time";

		let spentTime = data[currentMonthh][clickedDay]["TimeToComplete"];

		var h = Math.floor(spentTime / 3600);
    	var m = Math.floor(spentTime % 3600 / 60);
    	var s = Math.floor(spentTime % 3600 % 60);

    	var hDisplay = h > 0 ? h + (h == 1 ? " hour, " : " hours, ") : "";
    	var mDisplay = m > 0 ? m + (m == 1 ? " minute, " : " minutes, ") : "";
    	var sDisplay = s > 0 ? s + (s == 1 ? " second" : " seconds") : "";

		finished_div_time.innerHTML = "Time spent: "+ hDisplay + mDisplay + sDisplay;

		finished_div.appendChild(finished_div_title);
		finished_div.appendChild(finished_div_time);
		right_side_div.appendChild(finished_div);
	}

	createExercise = function (event) {
		if (canMakeExercise){
			let exercise_div = document.createElement("div");
			exercise_div.classList.add("exercise");

			let exerciseNumber_div = document.createElement("div");
			exerciseNumber_div.classList.add("exerciseNumber");
			exerciseNumber_div.innerHTML = "#";

			let exerciseRemove_btn = document.createElement("i");
			exerciseRemove_btn.className = exerciseRemove_btn.className + " fa fa-remove exercise-remove-btn animated-05";
			exerciseRemove_btn.addEventListener("click", removeExerciseLocal, true);

			let saveLocaly_btn = document.createElement("i");
			saveLocaly_btn.className = saveLocaly_btn.className + " fa fa-check exercise-saveLocal-btn animated-05";
			saveLocaly_btn.addEventListener("click", saveLocalyExercise, true);
			
			let buttonHolder = document.createElement("div");
			buttonHolder.classList.add("buttonHolder");

			buttonHolder.appendChild(saveLocaly_btn);
			buttonHolder.appendChild(exerciseRemove_btn);

			let exerciseName_input = document.createElement("input");
			exerciseName_input.type = "text";
			exerciseName_input.id = "exercise-name";
			exerciseName_input.className = "workout-input";
			exerciseName_input.style.display = "block";
			exerciseName_input.placeholder = "Exercise name";

			let reps_sec_input = document.createElement("input");
			reps_sec_input.type = "number";
			reps_sec_input.min = "0";
			reps_sec_input.id = "reps_sec_input";
			reps_sec_input.className = "workout-input";
			reps_sec_input.placeholder = "20";
			
			let reps_sec_text = document.createElement("div");
			reps_sec_text.id = "choiceText";
			reps_sec_text.innerHTML = "Reps";

			let choiceRadioReps = document.createElement("input");
			choiceRadioReps.type = "radio";
			choiceRadioReps.name = "choice";
			choiceRadioReps.value = "Reps";
			choiceRadioReps.defaultChecked = true;

			let choiceRadioSec = document.createElement("input");
			choiceRadioSec.type = "radio";
			choiceRadioSec.name = "choice";
			choiceRadioSec.value = "Sec";

			let choiceHolder = document.createElement("div");
			choiceHolder.id = "choiceHolder";
			choiceHolder.addEventListener("click", checkChoice, false);

			exerciseNumber_div.appendChild(buttonHolder);
			exercise_div.appendChild(exerciseNumber_div);
			exercise_div.appendChild(exerciseName_input);

			exercise_div.appendChild(reps_sec_input);
			exercise_div.appendChild(reps_sec_text);

			choiceHolder.appendChild(choiceRadioReps);
			choiceHolder.appendChild(choiceRadioSec);
			exercise_div.appendChild(choiceHolder);

			exercisesContainer.appendChild(exercise_div);

			disableAddingExercise();
		}
	}

	disableAddingExercise = function () {
		canMakeExercise = false;
		document.getElementById("add-exercises-btn").classList.add("locked-add-button");
	}

	enableAddingExercise = function () {
		canMakeExercise = true;
		document.getElementById("add-exercises-btn").classList.remove("locked-add-button");
	}

	checkChoice = function () {
		let choiceHolder = document.getElementById("choiceHolder");
		let repsChoice = choiceHolder.firstChild;
		let secChoice = choiceHolder.lastChild;

		if (repsChoice.checked){
			document.getElementById("choiceText").innerHTML = repsChoice.value;
		} else {
			document.getElementById("choiceText").innerHTML = secChoice.value;
		}
	}

	saveLocalyExercise = function () {
		newExerciseEntry = {
			"ExerciseID" : "0",
			"ID": "0",
			"WorkoutID": "0",
			"duration" : "0",
			"name": document.getElementById("exercise-name").value,
			"quantity": "0"
		}

		let choiceHolder = document.getElementById("choiceHolder");
		let repsChoice = choiceHolder.firstChild;
		let secChoice = choiceHolder.lastChild;

		if (repsChoice.checked){
			newExerciseEntry["quantity"] = document.getElementById("reps_sec_input").value;
		} else
			newExerciseEntry["duration"] = document.getElementById("reps_sec_input").value;

		if (data[currentMonthh][clickedDay] != undefined){
			newExerciseEntry["WorkoutID"] = data[currentMonthh][clickedDay]["WorkoutID"];	
		}

		data[currentMonthh][clickedDay]["WorkoutExercises"].push(newExerciseEntry);

		drawExercises();

		enableAddingExercise();

	}

	createNewWorkout = function () {
		newWorkout = {
			"Date": "",
			"ID": "0",
			"Rounds": "",
			"Time": "",
			"UserID": "",
			"WorkoutExercises": [],
			"WorkoutID": "0",
			"Completed": "0",
			"TimeToComplete": "",
			"WorkoutName": "",
			"r_between_e": "",
			"r_between_r": ""
		}

		newWorkout["Date"] = (new Date()).getFullYear()+"-"+ 
							 ((currentMonthh+1) < 10 ? '0'+(currentMonthh+1) : currentMonthh+1)+"-"+ 
							 (clickedDay < 10 ? '0'+clickedDay : clickedDay);

		newWorkout["UserID"] = getUserID();

		if (data[currentMonthh] == undefined){
			data[currentMonthh] = {};
		}

		data[currentMonthh][clickedDay] = newWorkout;
	}

	drawExercises = function () {
		exercisesContainer.innerHTML = "";

		// makes and draw exercises
		let index = 1;
		for (let i = 0; i < data[currentMonthh][clickedDay]["WorkoutExercises"].length; i++) {
			if (data[currentMonthh][clickedDay]["WorkoutExercises"][i] != undefined){
				let exercise_div = document.createElement("div");
				//exercise_div.addEventListener('click', removeExercise, true);

				let exerciseNumber_div = document.createElement("div");
				let exerciseName_div = document.createElement("div");
				//exerciseName_div.type = "text";
				//exerciseName_div.className = "workout-input";

				let exerciseRemove_btn = document.createElement("i");
				exerciseRemove_btn.className = exerciseRemove_btn.className + " fa fa-remove exercise-remove-btn animated-05";
				exerciseRemove_btn.addEventListener("click", removeExerciseLocal, true);

				let buttonHolder = document.createElement("div");
				buttonHolder.classList.add("buttonHolder");

				//buttonHolder.appendChild(saveLocaly_btn);
				buttonHolder.appendChild(exerciseRemove_btn);

				let exerciseReps_duration_div = document.createElement("div");
				//exerciseReps_duration_div.type = "text";
				//exerciseReps_duration_div.className = "workout-input";

				let h_i = document.createElement("span");
				h_i.innerHTML = i;
				h_i.style.display = "none";

				exercise_div.classList.add("exercise");
				exerciseNumber_div.innerHTML = index+".";
				exerciseName_div.innerHTML = data[currentMonthh][clickedDay]["WorkoutExercises"][i]["name"];

				exerciseNumber_div.appendChild(buttonHolder);

				if (data[currentMonthh][clickedDay]["WorkoutExercises"][i]["duration"] == 0)
					exerciseReps_duration_div.innerHTML = data[currentMonthh][clickedDay]["WorkoutExercises"][i]["quantity"] + " Reps";
				else
					exerciseReps_duration_div.innerHTML = data[currentMonthh][clickedDay]["WorkoutExercises"][i]["duration"] + " Sec";

				exercise_div.appendChild(exerciseNumber_div);
				exercise_div.appendChild(exerciseName_div);
				exercise_div.appendChild(exerciseReps_duration_div);
				exercise_div.appendChild(h_i);

				exercisesContainer.appendChild(exercise_div);

				data[currentMonthh][clickedDay]["WorkoutExercises"][i]["DOMnode"] = exercise_div;
				index++;
			}
		}
	}

	this.exitWorkoutModal = function () {

		if (document.getElementById("exercises").children.length == 0 || !canMakeExercise){
			document.getElementById("exercises").innerHTML = "";
			enableAddingExercise();
			clickedElement.lastChild.innerHTML = "";
			delete data[currentMonthh][clickedDay];
		}

		clearInterval(interval);

		document.getElementById("workoutOverlay").style.height = "0%";
    	document.getElementById("workoutOverlayInner").style.height = "0%";
	}

	editExercise = function () {
		console.log("hiii");
		exercisesContainer.innerHTML = "";
		let index = 1;
		for (var key in createdExercises) {
    		// check if the property/key is defined in the object itself, not in parent
    		if (createdExercises.hasOwnProperty(key)) { 
    			//console.log(createdExercises[key].children[1]);
    			createdExercises[key].children[1].innerText = index + ".";
    			exercisesContainer.appendChild(createdExercises[key]);          
        		//console.log(key, createdExercises[key]);
    		}
    		index++;
		}
	}

	this.clearChoosenExercises = function () {
		choosenExercises = [];
	}

	removeExerciseLocal = function(event) {
		console.log("removee");
		let target = event.target;
		while (true){
			if (!target.classList.contains("exercise")){
				target = target.parentElement;
			} else {
				break;
			}
		}
		let removeIndex = target.lastChild.innerHTML;
		
		data[currentMonthh][clickedDay]["WorkoutExercises"][removeIndex] = undefined;
		//delete createdExercises[target.children[1].innerText.substring(0, target.children[1].innerText.length-1)-1];
		document.getElementById("exercises").removeChild(target);
		
		if (!canMakeExercise){
			enableAddingExercise();
		}

		drawExercises();
		//let index_str = target.children[0].innerHTML;
		//let index_int = parseInt(index_str.substring(0, index_str.length-1)) - 1;
		//deleteExercise(data[currentMonthh][clickedDay]["WorkoutExercises"][index_int]["ID"]);
		//displayWorkoutModal(document.getElementById("modal-date-dayName").innerHTML, document.getElementById("modal-date-day").innerHTML);
	}

	makeImg = function(src, name, option){
		let img = document.createElement("img");
		img.src = src;
		img.width = 50;
		img.height = 50;
		img.id = "img_"+name;
		img.classList.add("workout_img");
		if (option == 0)
			img.addEventListener("click", addExercise, false);
		else
			img.addEventListener("click", removeExercise, false);
		return img;
	}

	this.clicked = function(event) {
		let target = event.target;
		while (true){
			if (!target.classList.contains("cell")){
				target = target.parentElement;
			} else {
				break;
			}
		}

		clickedElement = target;
		clickedDay = target.firstChild.innerHTML;
		let dayName = daysNamess[new Date(yearr+"-"+(currentMonthh+1)+"-"+clickedDay).getDay()];
		displayWorkoutModal(dayName, clickedDay);
	}
	
	this.initMonth = function(month) {
		this.currentMonth = month;
		currentMonthh = this.currentMonth;
		this.monthName = this.monthsNames[month];
		this.daysInMonth = (new Date(this.year, this.currentMonth+1, 0)).getDate();
		this.firstDayInMonth = new Date(this.year, this.currentMonth, 1).getDay() - 1;
		if (this.firstDayInMonth < 0)
			this.firstDayInMonth = 6;
		this.firstDayInMonthName = this.daysNames[this.firstDayInMonth];
	}
	
	this.makeDay = function(row, dayNumber, id) {
		let cell = document.createElement('div');
		cell.classList.add('cell');
		if (id == 1) { //checks if this day is a day from prev month or next month
			cell.classList.add('extraDay');
			cell.classList.add('prev');
			cell.addEventListener('click', this.prevMonthDayClicked, false);
		} else if (id == 2) {
			cell.classList.add('extraDay');
			cell.classList.add('next');
			cell.addEventListener('click', this.nextMonthDayClicked, false);
		} else { // if its not, then listener is added
			cell.addEventListener('click', this.clicked, false);
		}

		let inner_dayNumber = document.createElement('div');
		inner_dayNumber.innerHTML = dayNumber;
		inner_dayNumber.classList.add("day-number");

		cell.appendChild(inner_dayNumber);

		let inner_time = document.createElement("div");
		inner_time.classList.add('s-time');

		if (id == 0 && data.length != 0 && data[this.currentMonth] != undefined && data[this.currentMonth][dayNumber] != undefined) {
			let timeDiv = drawTimeIcon(data[this.currentMonth][dayNumber]["Time"]);
			//console.log(data[this.currentMonth][dayNumber]);
			inner_time.appendChild(timeDiv);
		}

		cell.appendChild(inner_time);

		if (this.currentMonth == this.activeMonth && id == 0 && dayNumber == this.day ){ //check if this day is the today's date
			inner_dayNumber.id = "active-day";
		}

		row.appendChild(cell);
	}

	// id : if 1, days are from prev month if 0, days in this month and 2 are days for next month
	this.makeWeek = function() {
		let row = document.createElement('div');
		row.classList.add('row');
		for(let i = 0; i < 7; i++){
			if (this.daysLeft > 0) {
				this.makeDay(row, this.countFromDay, 1);
				this.countFromDay++;
				this.daysLeft--;
			} else if (this.dayNumber > this.daysInMonth){
				this.makeDay(row, this.nextMonthDayCounter, 2);
				this.nextMonthDayCounter++;
			} else {
				this.makeDay(row, this.dayNumber, 0);
				this.dayNumber++;
			}
		}
		this.DOMElement.appendChild(row);
	}

	this.draw = function() {
		this.DOMElement = document.createElement('div');
		this.DOMElement.classList.add('table');
		this.daysLeft = this.firstDayInMonth; // number of days from previous month
		this.countFromDay = (new Date(this.year, this.currentMonth, 0)).getDate() - this.firstDayInMonth + 1; //prev. month days - number of day that month starts with; days from previous month (example: 28, 29, 30)
		this.dayNumber = 1;
		this.nextMonthDayCounter = 1;

		// names of days
		let daysNamesDiv = document.createElement('div');
		daysNamesDiv.id = "daynames";
		daysNamesDiv.classList.add('row');
		for(let i = 0; i < this.daysNamesToDraw.length; i++){
			let div = document.createElement('div');
			div.classList.add('cell');
			div.classList.add('dayname');
			if (i == this.dayInWeek-1 && this.currentMonth == this.activeMonth)
				div.id = "active-dayname";
			div.innerHTML = this.daysNamesToDraw[i].substring(0, 3);
			daysNamesDiv.appendChild(div);
		}
		this.DOMElement.appendChild(daysNamesDiv);
		// * name of days

		for(let i = 0; i < 6; i++) {
			this.makeWeek();
		}

		//adds arrows to navigate months
		this.parentElement.appendChild(this.DOMElement);
		this.parentElement.appendChild(calendarControlDiv);
	}


	saveWorkout = function(event) {

		if (document.getElementById("exercises").children.length != 0){
			let request = 'ID='+data[currentMonthh][clickedDay]["ID"]+'&Date='+data[currentMonthh][clickedDay]["Date"]+'&Time='+data[currentMonthh][clickedDay]["Time"]+'&UserID='+data[currentMonthh][clickedDay]["UserID"]+'&WorkoutID='+data[currentMonthh][clickedDay]["WorkoutID"]+'&WorkoutName='+data[currentMonthh][clickedDay]["WorkoutName"]+'&Rounds='+data[currentMonthh][clickedDay]["Rounds"]+'&r_between_e='+data[currentMonthh][clickedDay]["r_between_e"]+'&r_between_r='+data[currentMonthh][clickedDay]["r_between_r"]+''
			let WorkoutID;
			saveWorkoutToDatabase(request);
			setTimeout(function(){
        		WorkoutID = getLastAddedWorkoutID();

        		for(let i = 0; i < data[currentMonthh][clickedDay]["WorkoutExercises"].length; i++) {
					exercise_request = 'ID='+data[currentMonthh][clickedDay]["WorkoutExercises"][i]["ID"]+'&ExerciseID='+data[currentMonthh][clickedDay]["WorkoutExercises"][i]["ExerciseID"]+'&WorkoutID='+WorkoutID+'&duration='+data[currentMonthh][clickedDay]["WorkoutExercises"][i]["duration"]+'&quantity='+data[currentMonthh][clickedDay]["WorkoutExercises"][i]["quantity"]+'&name='+data[currentMonthh][clickedDay]["WorkoutExercises"][i]["name"]+' ';
					saveExerciseToDatabase(exercise_request);
				}

			getNewData();

			displayMessageInWorkoutModal("Saved!", 3);

    		},200);

			setTimeout(function(){
				data = getUpdatedData();
			}, 400);

		} else {
			displayMessageInWorkoutModal("You need to add atleast one exercise to save this workout", 5);
		}
	}

	displayMessageInWorkoutModal = function (message, secondsToHide) {
		document.getElementById("messages").innerHTML = message;
		document.getElementById("messages").style.display = "block";
		setTimeout(function(){
			document.getElementById("messages").style.display = "none";
		}, (secondsToHide*1000));
	}

	updateWorkoutStartTime = function () {
		data[currentMonthh][clickedDay]["Time"] = document.getElementById("Time").value;
		clickedElement.lastChild.firstChild.lastChild.innerHTML = data[currentMonthh][clickedDay]["Time"];
	}

	updateWorkoutNumRounds = function () {
		data[currentMonthh][clickedDay]["Rounds"] = document.getElementById("n-rounds").value;
	}

	updateWorkoutRestExercises = function () {
		data[currentMonthh][clickedDay]["r_between_e"] = document.getElementById("r_between_e").value;
	}

	updateWorkoutRestRounds = function () {
		data[currentMonthh][clickedDay]["r_between_r"] = document.getElementById("r_between_r").value;
	}

	this.nextMonth = function() {
		this.currentMonth = (this.currentMonth+1) % 12;
		this.initMonth(this.currentMonth);
	}

	this.prevMonth = function() {
		this.currentMonth -= 1;
		if (this.currentMonth < 0)
			this.currentMonth = 11;
		this.initMonth(this.currentMonth);
	}

	this.prevMonthDayClicked = function(event) {
		prevMonth();
		setTimeout(function(){
			this.clicked(event);
		}.bind(this), 500);
	}.bind(this)

	this.nextMonthDayClicked = function(event) {
		nextMonth();
		setTimeout(function(){
			this.clicked(event);
		}.bind(this), 500);
	}.bind(this)

	this.backToActiveMonth = function(event) {
		this.initMonth(this.activeMonth);
		//redraw
		this.reDraw();
		//parentElement.innerHTML = "";
		//draw();
	}.bind(this)

	this.dateReformat = function(date) {
		let d = new Date(date);
		let dayName = daysNamess[d.getDay()];
		console.log(dayName);
	}

	this.getData = function() {
		return data;
	}.bind(this);

	this.setData = function (dataa) {
		data = dataa;
	}.bind(this);

	this.reDraw = function(){
		parentElement.innerHTML = "";
		this.draw();
	}.bind(this);

	this.resetData = function () {
		data = [];
	}.bind(this)
	/* START */

	this.initMonth(this.activeMonth);
	this.parentElement = parentElement;

	let calendarControlDiv = document.createElement('div');
	calendarControlDiv.classList.add('clearfix');
	calendarControlDiv.id = "monthControlbtns"

	let nextMdiv = document.createElement('div');
	nextMdiv.innerHTML = ">";
	nextMdiv.id = "next-month"
	let prevMdiv = document.createElement('div');
	prevMdiv.innerHTML = "<";
	prevMdiv.id = "prev-month";
	let activeMdiv = document.createElement('div');
	activeMdiv.innerHTML = "Active";
	activeMdiv.id = "active-month";

	calendarControlDiv.appendChild(prevMdiv);
	calendarControlDiv.appendChild(nextMdiv);
	calendarControlDiv.appendChild(activeMdiv);
	this.events = events;
	let clickedDays = [];

	let data = [];
	if (this.events != undefined && this.events.length != 0)
		data = this.events;

	document.getElementById("Time").addEventListener("change", updateWorkoutStartTime, false);
	document.getElementById("n-rounds").addEventListener("change", updateWorkoutNumRounds, false);
	document.getElementById("r_between_e").addEventListener("change", updateWorkoutRestExercises, false);
	document.getElementById("r_between_r").addEventListener("change", updateWorkoutRestRounds, false);

}