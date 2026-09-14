function increaseCart(id){

    //cart item increase korar jonno AJAX request pathacchi

    var xhttp = new XMLHttpRequest();
//ajax req pathanor jnno xmlrhtpreq objct crt

    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 && this.status == 200){

//JSON response ke JavaScript object e convert korchi

            var response = JSON.parse(this.responseText);
            console.log(response);

   if(response.status=="success"){

                alert(response.message);

                location.reload();

            }

        }

    };

//data pathacchi
    xhttp.open(
        "GET",
        "../control/cart_action.php?action=increase&id="+id,
        true
    );

//ajax srvr e req ptcci 
    xhttp.send();

}




function decreaseCart(id){

    //cart item decrease korar jonno AJAX request pathacchi

    var xhttp = new XMLHttpRequest();


    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 && this.status == 200){


            //New1: JSON response receive korchi

            var response = JSON.parse(this.responseText);


            console.log(response);


            if(response.status=="success"){

                alert(response.message);

                location.reload();

            }
            else{

                alert(response.message);

            }

        }

    };


    xhttp.open(
        "GET",
        "../control/cart_action.php?action=decrease&id="+id,
        true
    );


    xhttp.send();

}


function removeCart(id){

    //New1: cart item remove korar jonno AJAX request pathacchi

    var xhttp = new XMLHttpRequest();


    xhttp.onreadystatechange = function(){

        if(this.readyState == 4 && this.status == 200){


            //New1: JSON response receive korchi

            var response = JSON.parse(this.responseText);


            console.log(response);


            if(response.status=="success"){

                alert(response.message);

                location.reload();

            }

        }

    };


    xhttp.open(
        "GET",
        "../control/cart_action.php?action=remove&id="+id,
        true
    );


    xhttp.send();

}