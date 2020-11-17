$(document).ready(function() {
    
    $('.collapse').collapse();

    //calculateSummary();
});

/*function calculateSummary() {

    document.querySelector("");
};*/

function createNewSemester() {

    $('.collapse').collapse("hide");
    
    let PreviousSemester = document.querySelectorAll(".card-header button");
    
    var last = PreviousSemester[PreviousSemester.length - 1]
    last = parseInt(last.innerHTML.replace(". Semester",""));
    let id = last + 1;
    
    let template = `<div class="card">
                        <div class="card-header" id="heading`+id+`">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse`+id+`" aria-expanded="true" aria-controls="collapse`+id+`" onclick="hideInput()">
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
                                <button type="button" class="btn btn-primary mt-3" id="`+id+`" onclick="showInput()" >Neues Fach hinzufügen</button>
                            </div>
                        </div>
                    </div>`

    let accordion = document.querySelector(".accordion");
    accordion.innerHTML = accordion.innerHTML + template;
};

function showInput() {

    let Input = document.querySelector("#InputRow");

    let id = event.target.getAttribute("id") + "-s";

    let Inputfields = `<tr id="InputRow" semester="`+id+`">
                            <td><input type="text" class="form-control" id="InputSubject" aria-describedby="Input Fach" placeholder="Fach"><div class="invalid-feedback">Dieses Feld ist erforderlich</div></td>
                            <td><input type="text" class="form-control" id="InputGrade" aria-describedby="Input Note" placeholder="Note"><div class="invalid-feedback">Eingabe muss eine Zahl sein</div></td>
                            <td><input type="text" class="form-control" id="InputECTS" aria-describedby="Input ECTS" placeholder="ECTS"><div class="invalid-feedback">Eingabe muss eine ganzzahlige Zahl sein</div></td>
                            <td></td>
                        </tr>`;

    if(Input == null) {
                
        let element = event.target.parentNode.querySelector(".divider");
        element.insertAdjacentHTML("beforebegin", Inputfields);

        document.querySelector("#InputSubject").focus();
        document.querySelector("#InputSubject").select();
    
        document.addEventListener("keypress", sendCreateRequest);
    }
}

function hideInput() {

    try {

        document.querySelector('#InputRow').parentNode.removeChild(document.querySelector('#InputRow'));

    } catch (e) {
        //catch if no Input is shown
    };

}


function sendCreateRequest(event) {

    if (event.keyCode == 13) {
    
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
                document.querySelector("#InputGrade").nextSibling.style.display = "none";
            }

        }catch (e) {

            document.querySelector("#InputGrade").nextSibling.style.display = "block";
        };

        try {
            GradeInput = document.querySelector('#InputGrade').value; 
                   
            if (GradeInput == ""){
            
                GradeBool = 0;

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
    
            document.removeEventListener("keypress", sendCreateRequest);
            document.querySelector('#InputRow').parentNode.removeChild(document.querySelector('#InputRow'));
    
        } else if ((SubjectBool == 2 && GradeBool == 0 && ECTSBool == 0) || (SubjectBool == 2 && GradeBool == 2 && ECTSBool == 0) ||  (SubjectBool == 2 && GradeBool == 0 && ECTSBool == 2) || (SubjectBool == 2 && GradeBool == 2 && ECTSBool == 2)) {

            document.removeEventListener("keypress", sendCreateRequest);
            
            let semester = parseInt(document.querySelector('#InputRow').getAttribute("semester"));

            let newRow = `<tr id="newRow">
                            <td>`+SubjectInput+`</td>
                            <td>`+GradeInput+`</td>
                            <td>`+ECTSInput+`</td>
                            <td>
                                <form method="POST">
                                    <input type="hidden" name="_token" value="HL0Sf3iD1W0OFvBGxEeuRrHpeo2x1GIjgUAXp4Qx">                                        
                                    <input type="hidden" name="_method" value="DELETE">
                                    <div class="form-group row mb-0">
                                        <div>
                                            <button type="submit" class="btn btn-sm"><i class="fas fa-times color"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </td>
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
                    
                    document.querySelector("#newRow").querySelector("form").setAttribute("action", "http://application.test:8000/grades/"+response.id);
                    document.querySelector("#newRow").removeAttribute("id");
                }
            });

        }
    }
};