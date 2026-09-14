function searchMedicine() {
    var search =
        document.getElementById(
            "searchInput"
        ).value;

    var category =
        document.getElementById(
            "categoryFilter"
        ).value;


    var xttp =
        new XMLHttpRequest();


    xttp.onreadystatechange =
        function()
        {
            if (this.readyState == 4)
            {
                if (this.status == 200)
                {

                    var data =
                        JSON.parse(
                            this.responseText
                        );


                    var result =
                        document.getElementById(
                            "result"
                        );


                    result.innerHTML = "";


                    if (data.length == 0)
                    {
                        result.innerHTML =
                            "<p>" +
                            "No medicine found." +
                            "</p>";
                    }
                    else
                    {

                        for (
                            var i = 0;
                            i < data.length;
                            i++
                        )
                        {

                            result.innerHTML +=

                                "<div class='medicineBox'>" +

                                "<h3>" +
                                data[i].medicine_name +
                                "</h3>" +

                                "<p>Company: " +
                                data[i].company +
                                "</p>" +

                                "<p>Price: " +
                                data[i].price +
                                " TK</p>" +

                                "<p>Category: " +
                                data[i].category_name +
                                "</p>" +

                                "</div>" +

                                "<hr>";
                        }
                    }
                }
            }
        };


    xttp.open(
        "GET",
        "../control/searchControl.php?search=" +
        encodeURIComponent(search) +
        "&category=" +
        encodeURIComponent(category),
        true
    );


    xttp.send();
}


document.getElementById(
    "searchInput"
).addEventListener(
    "keyup",
    searchMedicine
);


document.getElementById(
    "categoryFilter"
).addEventListener(
    "change",
    searchMedicine
);
