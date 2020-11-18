$(document).ready(function() {
    AJAXRequest("0");

    if (document.querySelector('.alert') != null) {

        setTimeout(() => {
            document.querySelector('.alert').style.display = "none";
        }, 4000);
    }
});

$("#preceding").click(function(event){
    event.preventDefault();

    AJAXRequest("1");
});

$("#following").click(function(event){
    event.preventDefault();

    AJAXRequest("2");
});

function AJAXRequest(request) {
    $.ajax({
        url: "/ajax",
        type:"GET",
        data:{identifier: request},
  
        success: function(response){

            $("h2").html(response.month);
            
            let list = document.querySelectorAll(".day");
        
            let count = +response.days + +response.firstWeekday -2;
            let i = 0;
            let day = 1;

            for (item of list) {

                item.innerHTML = '<div class="cell_wrapper"><p>&nbsp</p></div>';

                if (i >= response.firstWeekday -1 && i <= count) {
                    item.querySelector("p").innerHTML = day;
                    day ++;
                }

                i++;
            }

            for (item of response.events) {

                let day = item['date'].slice(8);
                
                if (day.startsWith('0')) {
                
                    day = day.slice(1);
                }

                let updatedlist = document.querySelectorAll(".day");

                for (cell of updatedlist) {

                    if (cell.querySelector("p").textContent == day) {
                        cell.querySelector(".cell_wrapper").innerHTML = cell.querySelector(".cell_wrapper").innerHTML + "<a href = 'calendar/" + item['id'] + "/edit' class='event'><p>"+item['time'].slice(0,5)+"</p><p>"+item['title']+"</p></a>";
                    }

                }
            }
        }
    })
};