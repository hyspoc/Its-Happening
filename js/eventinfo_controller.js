/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
window.onload = function(){
    $.ajax({
        method: "POST",
        url: "organizerdashboard.php",
        data: {username: "qwerty"}
    }).done(function (data) {
        console.log(data);
        var searchData = $.parseJSON(data);
        dataLength = data.length;
        if (dataLength == 0) {
            $(".ulist").html('No data found. <a href="index.php">View all</a>');
        } else {
            for (var i = 0; i < dataLength; i++) {
                var event = searchData[i];
                console.log(event);
                organizerDashboard(event);
                //populateMyEvents(event);
                

            }
        }
    });
}

function populateMyEvents(data) {
    try {
        var myEventsCard = document.getElementById('myevents')[0];
        var ulist = document.createElement('ul');
        ulist.classname = "ulist";
        for (var i = 0; i < data.length; i++) {
            var list = document.createElement('li');
            list.classname = "listitem";
            var img = document.createElement('img');
            img.src = data[i].image;
            img.classname = "listimg";
            var h3 = document.createElement('h3');
            h3.classname = "eventTitle";
            h3.text = "";
            var para = document.createElement('p');
            para.classname = "eventdesc";
            para.text = "";
            list.appendChild(img);
            list.appendChild(h3);
            list.appendChild(para);
            ulist.appendChild(list);

        }
        myEventsCard.appendChild(ulist);

    } catch (e) {
        console.log("Exception in populateMyEvents - " + e);
    }
}