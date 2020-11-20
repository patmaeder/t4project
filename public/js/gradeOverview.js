$(document).ready(function() {
    
    $('.collapse').collapse();

    calculateSummary();
});

function calculateSummary() {

    let tables = document.querySelectorAll("table");

    tables.forEach((table) => {

        let grades = table.querySelectorAll(".grade");

        let avg = 0;
        let count = 0;

        for (var i = 0; i < grades.length; i++) {
            
            if (grades[i].innerHTML != "") {

                avg = avg + parseFloat(grades[i].innerHTML);
                count = count +1;
            }
        }

        avg = (avg/count).toFixed(2);
        table.querySelector("#avg").innerHTML = "<b>&Oslash; "+avg+"</b>";

        let ects = table.querySelectorAll(".ects");

        let sum = 0;

        for (var i = 0; i < ects.length; i++) {
            
            if (ects[i].innerHTML != "") {

                sum = sum + parseInt(ects[i].innerHTML);
            }
        }

        table.querySelector("#ECTS").innerHTML = "<b>"+sum+"</b>";
    })
};

function createNewSemester() {

    $('.collapse').collapse("hide");
    
    let PreviousSemester = document.querySelectorAll(".card-header button");
    
    var last = PreviousSemester[PreviousSemester.length - 1]
    last = parseInt(last.innerHTML.replace(". Semester",""));
    let id = last + 1;
    
    let template = `<div class="card">
                        <div class="card-header" id="heading`+id+`">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse`+id+`" aria-expanded="true" aria-controls="collapse`+id+`" >
                                `+id+`. Semester
                                </button>
                            </h2>
                        </div>

                        <div id="collapse`+id+`" class="collapse show" aria-labelledby="heading`+id+`" data-parent="#accordionExample">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0 " style="width: 50%" >Fach</th>
                                            <th class="border-top-0">Note</th>
                                            <th class="border-top-0">ECTS</th>
                                            <th class="border-top-0"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="divider">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="border-top-0">&nbsp</td>
                                            <td class="border-top-0" id='avg'></td>
                                            <td class="border-top-0" id='ECTS'></td>
                                            <td class="border-top-0"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-primary mt-3" id="`+id+`" onclick="createNewSubject()" >Neues Fach hinzufügen</button>
                            </div>
                        </div>
                    </div>`

    let accordion = document.querySelector(".accordion");
    accordion.innerHTML = accordion.innerHTML + template;
};

function showInput(ph_Subject, ph_Grade, ph_ECTS, InserElement) {

    let Input = document.querySelector("#InputRow");

    let id = event.target.getAttribute("id") + "-s";

    let Inputfields = `<tr id="InputRow" semester="`+id+`">
                            <td><input type="text" class="form-control" id="InputSubject" aria-describedby="Input Fach" placeholder="Fach" value="`+ph_Subject+`"><div class="invalid-feedback">Dieses Feld ist erforderlich</div></td>
                            <td><input type="text" class="form-control" id="InputGrade" aria-describedby="Input Note" placeholder="Note" value="`+ph_Grade+`"><div class="invalid-feedback">Eingabe muss eine Zahl sein</div></td>
                            <td><input type="text" class="form-control" id="InputECTS" aria-describedby="Input ECTS" placeholder="ECTS" value="`+ph_ECTS+`"><div class="invalid-feedback">Eingabe muss eine ganzzahlige Zahl sein</div></td>
                            <td></td>
                        </tr>`;

    if(Input == null) {
                
        $('[data-toggle=collapse]').prop('disabled',true);

        InserElement.insertAdjacentHTML("beforebegin", Inputfields);

        document.querySelector("#InputSubject").focus();
        document.querySelector("#InputSubject").select();

        return true;

    } else {

        return false;
    }
}

function removeEevntListener() { document.removeEventListener("keypress", awaitEnter);};

function createNewSubject() {

    let element = event.target.parentNode.querySelector(".divider");

    let response = showInput("", "", "", element);
    
    if (response) {

        document.addEventListener("keypress", awaitEnter = (event) => {

            if (event.keyCode == 13) {
    
                let response = validateInput();
    
                if (response == 0) {
    
                    removeEevntListener();
                    document.querySelector('#InputRow').parentNode.removeChild(document.querySelector('#InputRow'));

                    $('[data-toggle=collapse]').prop('disabled',false);
    
                } else if (response == 2) {
                    
                    sendCreateRequest();

                    $('[data-toggle=collapse]').prop('disabled',false);
                }
            }
        })

    }
};

function sendCreateRequest() {

    document.removeEventListener("keypress", awaitEnter);
        
    let semester = parseInt(document.querySelector('#InputRow').getAttribute("semester"));
    let SubjectInput = document.querySelector('#InputSubject').value; 
    let GradeInput = document.querySelector('#InputGrade').value; 
    let ECTSInput = document.querySelector('#InputECTS').value; 

    let newRow = `<tr id="newRow">
                    <td onclick="editSubject()">`+SubjectInput+`</td>
                    <td class="grade" onclick="editSubject()" >`+GradeInput+`</td>
                    <td class="ects" onclick="editSubject()" >`+ECTSInput+`</td>
                    <td><i class="fas fa-times color" onclick="deleteSubject()"></i></td>
                </tr>`;
    
    document.querySelector('#InputRow').insertAdjacentHTML("beforebegin", newRow);
    document.querySelector('#InputRow').parentNode.removeChild(document.querySelector('#InputRow'));

    let RequestBody = {"semester": semester};

    if (SubjectInput != "") {RequestBody["subject"] = SubjectInput};
    if (GradeInput != "") {RequestBody["grade"] = parseFloat(GradeInput)};
    if (ECTSInput != "") {RequestBody["ECTS"] = parseInt(ECTSInput)};
    
    $.ajax({
        url: "/grades",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"POST",
        data: RequestBody,

        success: function(response) {
            
            document.querySelector("#newRow").setAttribute("id", response.id);
        }
    });

    calculateSummary();
};

function editSubject() {

    let row = event.target.parentElement;
    let id = row.getAttribute("id");
    let Subject = row.querySelector("td").innerHTML;
    let Grade = row.querySelector(".grade").innerHTML;
    let ECTS = row.querySelector(".ects").innerHTML;
    
    let response = showInput(Subject, Grade, ECTS, row);
    
    if (response) {
      
        row.parentNode.removeChild(row);

        document.addEventListener("keypress", awaitEnter = (event) => {
    
            if (event.keyCode == 13) {
    
                let response = validateInput();
    
                if (response == 2) {
    
                    sendEditRequest(id);
                    $('[data-toggle=collapse]').prop('disabled',false);
                } 
            }
        });
    }
};

function sendEditRequest(id) {

    document.removeEventListener("keypress", awaitEnter);
        
    let SubjectInput = document.querySelector('#InputSubject').value; 
    let GradeInput = document.querySelector('#InputGrade').value; 
    let ECTSInput = document.querySelector('#InputECTS').value; 

    let newRow = `<tr id="`+id+`">
                    <td onclick="editSubject()">`+SubjectInput+`</td>
                    <td class="grade" onclick="editSubject()" >`+GradeInput+`</td>
                    <td class="ects" onclick="editSubject()" >`+ECTSInput+`</td>
                    <td><i class="fas fa-times color" onclick="deleteSubject()"></i></td>
                </tr>`;
    
    document.querySelector('#InputRow').insertAdjacentHTML("beforebegin", newRow);
    document.querySelector('#InputRow').parentNode.removeChild(document.querySelector('#InputRow'));

    let RequestBody = {};

    if (SubjectInput != "") {RequestBody["subject"] = SubjectInput};
    if (GradeInput != "") {RequestBody["grade"] = parseFloat(GradeInput)};
    if (ECTSInput != "") {RequestBody["ECTS"] = parseInt(ECTSInput)};

    $.ajax({
        url: "http://application.test:8000/grades/"+id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"PATCH",
        data: RequestBody,

        success: function(response) {}
    });

    calculateSummary();
};

function deleteSubject() {

    event.preventDefault();
   
    let row = event.target.parentElement.parentElement;

    let id = row.getAttribute("id");

    row.parentNode.removeChild(row);

    $.ajax({
        url: "http://application.test:8000/grades/"+id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type:"DELETE",
        data: {},

        success: function(response) {}
    });

    calculateSummary();
}

function validateInput() {
   
    let SubjectInput;
    let SubjectBool = 0;
    let GradeInput;
    let GradeBool = 0;
    let ECTSInput;
    let ECTSBool = 0;

    try {
        SubjectInput = document.querySelector('#InputSubject').value; 
    
        if (SubjectInput == ""){

            SubjectBool = 0;
            document.querySelector("#InputSubject").nextSibling.style.display = "block";

        } else {

            SubjectBool = 2;
            document.querySelector("#InputSubject").nextSibling.style.display = "none";
        }

    }catch (e) {

        document.querySelector("#InputSubject").nextSibling.style.display = "block";
    };

    try {
        GradeInput = document.querySelector('#InputGrade').value; 
                
        if (GradeInput == ""){
        
            GradeBool = 0;
            document.querySelector("#InputGrade").nextSibling.style.display = "none";

        } else if (isNaN(GradeInput)) {

            GradeBool = 1;
            document.querySelector("#InputGrade").nextSibling.style.display = "block";

        } else if (Number.isFloat(parseFloat(GradeInput))) {

            GradeBool = 2;
            document.querySelector("#InputGrade").nextSibling.style.display = "none";

        } else {

            GradeBool = 1;
        }
    
    }catch (e) {};

    try {
        ECTSInput = document.querySelector('#InputECTS').value; 
    
        if (ECTSInput == ""){

            ECTSBool = 0;
            document.querySelector("#InputECTS").nextSibling.style.display = "none";
            
        } else if (isNaN(ECTSInput)) {

            ECTSBool = 1;
            document.querySelector("#InputECTS").nextSibling.style.display = "block";
            
        } else if (Number.isInteger(parseInt(ECTSInput))) {

            ECTSBool = 2;
            document.querySelector("#InputECTS").nextSibling.style.display = "none";

        } else {

            ECTSInput = 1;
        }
        
    }catch (e) {};

    
    if (SubjectBool == 0 && GradeBool == 0 && ECTSBool == 0) {

        return 0;

    } else if ((SubjectBool == 2 && GradeBool == 0 && ECTSBool == 0) || (SubjectBool == 2 && GradeBool == 2 && ECTSBool == 0) ||  (SubjectBool == 2 && GradeBool == 0 && ECTSBool == 2) || (SubjectBool == 2 && GradeBool == 2 && ECTSBool == 2)) {

        return 2;

    } else {

        return 1;
    }
};
