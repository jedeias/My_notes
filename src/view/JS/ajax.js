
$(function() {

    $(".ArrayTrigger").on("click", function(){
            $.ajax({
                url: "../telas/pessoas/Agenda/agenda.php",
                success: function(result){
                    $(".response").html(result);
                },
                error: function name(result) {
                    $(".response").html("Has a error in this request. Please try again");

                }
            })
        })  
    })
