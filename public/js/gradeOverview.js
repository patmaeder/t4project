$('.collapse').collapse();

document.querySelector("#addSemester").addEventListener("click", () => {

    $('.collapse').collapse("hide");
    
    let PreviousSemester = document.querySelectorAll(".card-header button");
    
    var last = PreviousSemester[PreviousSemester.length - 1]
    last = parseInt(last.innerHTML.replace(". Semester",""));
    let id = last + 1;
    
    let template = `<div class="card">
                        <div class="card-header" id="heading`+id+`">
                            <h2 class="mb-0">
                                <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse`+id+`" aria-expanded="true" aria-controls="collapse`+id+`">
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

                                        <tr>
                                            <td><input type="text" class="form-control" id="InputSubject" aria-describedby="Input Fach" placeholder="Fach"></td>
                                            <td><input type="text" class="form-control" id="InputGrade" aria-describedby="Input Note" placeholder="Note"></td>
                                            <td><input type="text" class="form-control" id="InputECTS" aria-describedby="Input ECTS" placeholder="ECTS"></td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class='table-secondary'>
                                            <td class="border-top-0">&nbsp</td>
                                            <td class="border-top-0" id='avg'></td>
                                            <td class="border-top-0" id='ECTS'></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>`

    let accordion = document.querySelector(".accordion");
    accordion.innerHTML = accordion.innerHTML + template;

    document.querySelector("#InputSubject").focus();
    document.querySelector("#InputSubject").select();
});