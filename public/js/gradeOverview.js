$('.collapse').collapse();


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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="divider">
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="border-top-0">&nbsp</td>
                                            <td class="border-top-0" id='avg'></td>
                                            <td class="border-top-0" id='ECTS'></td>
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

    let Input = document.querySelectorAll("input");

    let id = event.target.getAttribute("id") + "-s";

    let Inputfields = `<tr id="InputRow" semester="`+id+`">
                            <td><input type="text" class="form-control" id="InputSubject" aria-describedby="Input Fach" placeholder="Fach"></td>
                            <td><input type="text" class="form-control" id="InputGrade" aria-describedby="Input Note" placeholder="Note"><div class="invalid-feedback">Eingabe muss eine Zahl sein</div></td>
                            <td><input type="text" class="form-control" id="InputECTS" aria-describedby="Input ECTS" placeholder="ECTS"><div class="invalid-feedback">Eingabe muss eine Zahl sein</div></td>
                        </tr>`;

    if(Input.length == 1) {
                
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
        let GradeInput;
        let GradeBool = false;
        let ECTSInput;
        let ECTSBool = false;
    
        try {
            SubjectInput = document.querySelector('#InputSubject').value; 
        
        }catch (e) {
            SubjectInput = ""; 
        };

        try {
            GradeInput = document.querySelector('#InputGrade').value; 
                   
            if (isNaN(GradeInput)){

                document.querySelector("#InputGrade").nextSibling.style.display = "block";

            } else {

                GradeBool = true;
                document.querySelector("#InputGrade").nextSibling.style.display = "none";
            }
        
        }catch (e) {
            GradeInput = ""; 
        };

        try {
            ECTSInput = document.querySelector('#InputECTS').value; 
        
            if (isNaN(ECTSInput)){

                document.querySelector("#InputECTS").nextSibling.style.display = "block";
            } else {

                ECTSBool = true;
                document.querySelector("#InputECTS").nextSibling.style.display = "none";
            }
       
        }catch (e) {
            ECTSInput = ""; 
        };
  
        
        if (SubjectInput == "" && GradeInput == "" && ECTSInput == "") {
    
            document.removeEventListener("keypress", sendCreateRequest);
            document.querySelector('#InputRow').parentNode.removeChild(document.querySelector('#InputRow'));
    
        } else if (GradeBool && ECTSBool) {

            document.removeEventListener("keypress", sendCreateRequest);
            
            let semester = parseInt(document.querySelector('#InputRow').getAttribute("semester"));

            let newRow = `<tr>
                            <td>`+SubjectInput+`</td>
                            <td>`+GradeInput+`</td>
                            <td>`+ECTSInput+`</td>
                        </tr>`;
            
            document.querySelector('#InputRow').insertAdjacentHTML("beforebegin", newRow);
            document.querySelector('#InputRow').parentNode.removeChild(document.querySelector('#InputRow'));

            let RequestBody = {"semester": semester};

            if (SubjectInput != "") {RequestBody["subject"] = SubjectInput};
            if (GradeInput != "") {RequestBody["grade"] = parseFloat(GradeInput)};
            if (ECTSInput != "") {RequestBody["ECTS"] = parseInt(ECTSInput)};
            
            console.log(RequestBody);

            $.ajax({
                url: "/grades",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type:"POST",
                data: RequestBody,
        
                success: function(response) {
                    console.log(response);
                }
            });

        }
    }
};