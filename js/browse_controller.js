/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//Browse result by category

window.onload = function () {
    var ind = document.getElementById('indicator').value;
    if (!ind) ind = 'All';
    document.getElementById(ind).style.backgroundColor = '#999999';

    addUserMarker(true);

    $.ajax({
        method: "POST",
        url: "Search.php",
        data: {indicator: $("#indicator").val(), keyword: $("#keyword").val()}
    }).done(function (data) {
        var searchData = $.parseJSON(data);

        dataLength = searchData.length;
        if (dataLength == 0) {
            $(".searchResult").html('<span class="selected">No results found. <a href="browse.php">View all</a></span>');
        } else {
            for (var i = 0; i < dataLength; i++) {
                var event = searchData[i];
                addElement(event);
                addMarker(event['latitude'], event['longitude'], event['name'], event['type'], false);
            }
        }
    });
    //addMenu();
}
function addElement(searchData) {

    var searchResultCard = document.getElementsByClassName('searchResult')[0];

    var iDiv0 = document.createElement('div');
    iDiv0.className = 'fond';

    var iSpan1 = document.createElement('span');
    iSpan1.className = 's1';
    var iSpan2 = document.createElement('span');
    iSpan2.className = 's2';

    iDiv0.appendChild(iSpan1);
    iDiv0.appendChild(iSpan2);

    var iDiv = document.createElement('div');
    iDiv.className = 'eventCard';

    var iDiv1 = document.createElement('div');
    iDiv1.className = 'eventThumbnail';

    var iImg = document.createElement('img');
    iImg.className = 'eventLeft';
    iImg.src = searchData["image"];

    iDiv1.appendChild(iImg);

    var innerDiv = document.createElement('div');
    innerDiv.className = 'eventRight';

    var ih1 = document.createElement('h1');
    ih1.textContent = searchData["name"];
    innerDiv.appendChild(ih1);

    var iDiv2 = document.createElement('div');
    iDiv2.className = 'eventAuthor';

    var iImg1 = document.createElement('img');
    iImg1.src = "https://randomuser.me/api/portraits/lego/5.jpg";
    iDiv2.appendChild(iImg1);
    var ih2 = document.createElement('h2');
    ih2.textContent = searchData["organizer"];
    iDiv2.appendChild(ih2);
    innerDiv.appendChild(iDiv2);

    

    var iDiv3 = document.createElement('div');
    iDiv3.className = 'eventSeparator';
    innerDiv.appendChild(iDiv3);

    var iP = document.createElement('p');
    iP.textContent = searchData["description"];
    innerDiv.appendChild(iP);

    var ih5 = document.createElement('p');
    ih5.className = 'eventHeading1';
    // var eventDate = new Date ( searchData["date"]);
    // var formattedDateText = eventDate.getDate();
    // var monthArray = {
    //                     0 : "Jan",
    //                     1 : "Feb",
    //                     2 : "Mar",
    //                     3 : "Apr",
    //                     4 : "May",
    //                     5 : "Jun",
    //                     6 : "Jul",
    //                     7 : "Aug",
    //                     8 : "Sept",
    //                     9 : "Oct",
    //                     10 : "Nov",
    //                     11 : "Dec",
    //                 };
    //
    // var formattedDateText = formattedDateText + " " + monthArray[eventDate.getMonth()];
    // var formattedDateText = formattedDateText + " " + eventDate.getFullYear();
    // ih5.textContent = formattedDateText;
    ih5.textContent = searchData["date"];

        var iul = document.createElement('ul');

        var ili1 = document.createElement('li');
        var iclass1 = document.createElement('i');
        iclass1.className = 'fa fa-eye fa-2x';

        ili1.appendChild(iclass1);

        var ili2 = document.createElement('li');
        var iclass2 = document.createElement('i');
        iclass2.className = 'fa fa-heart-o fa-2x';

        ili2.appendChild(iclass2);

        var ili3 = document.createElement('li');
        var iclass3 = document.createElement('i');
        iclass3.className = 'fa fa-envelope-o fa-2x';

        ili3.appendChild(iclass3);

        var ili4 = document.createElement('li');
        var iclass4 = document.createElement('i');
        iclass4.className = 'fa fa-share-alt fa-2x';

        ili4.appendChild(iclass4);

    // var iDiv4 = document.createElement('div');
    // iDiv4.className = 'eventFab';
    //
    // var iclass5 = document.createElement('i');
    // iclass5.className = 'fa fa-arrow-right fa-2x';
    //
    // iDiv4.appendChild(iclass5);

    iDiv.appendChild(iDiv1);
    iDiv.appendChild(innerDiv);
    iDiv.appendChild(ih5);
    iDiv.appendChild(iul);
    // iDiv.appendChild(iDiv4);

    var createA = document.createElement('a');
    createA.setAttribute('href', "event.php?event_id=" + searchData["event_id"]);
    createA.appendChild(iDiv);
    searchResultCard.appendChild(createA);
}
