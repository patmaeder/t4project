$(document).ready(AJAXRequest("0"));

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
          $("h2").html(response.month)
          
          let list = document.querySelectorAll(".day");
     
          let count = +response.days + +response.firstWeekday -2;
          let i = 0;
          let day = 1;

          for (item of list) {

            item.innerHTML = "&nbsp";

            if (i >= response.firstWeekday -1 && i <= count) {
                item.innerHTML = day;
                day ++;
            }

            i++;
          }
        },
    });
};