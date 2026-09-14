function searchOrder()
{

    // Order search korar jonno AJAX request pathacchi

    var text = document.getElementById("search").value;



    // Empty search validation

    if(text == "")
    {

        alert("Please enter order id");

        return;

    }

    //obj create XMLHttpRequest

    var xhttp = new XMLHttpRequest();



    //server response handle kore(callback func)
    xhttp.onreadystatechange = function()
    {


        if(this.readyState == 4 && this.status == 200)
        {


            // JSON response ke JavaScript object e convert korchi
            //json
            var response = JSON.parse(this.responseText);



            console.log(response);




            var html = "";




            response.forEach(function(order)
            {



                html += `

                <tr>


                <td>
                ${order.id}
                </td>



                <td>
                ${order.date}
                </td>



                <td>
                ${order.total}
                </td>



                <td>
                ${order.status}
                </td>



                <td>

                <a href="order_details.php?id=${order.id}">
                View
                </a>

                </td>



                </tr>

                `;



            });





            document.getElementById("orderData").innerHTML = html;



        }


    };





    // AJAX request pathacchi


    xhttp.open(

        "GET",

        "../control/ajax_control.php?search="+encodeURIComponent(text),

        true

    );





    // Server e request send korchi

    xhttp.send();



}