function displayUpcomingEvents() {
    removeTicketsDisplay();
    displayTickets(upcoming_tickets);
    document.getElementById('upcoming-events').style.color = "#404040";
    document.getElementById('upcoming-events').style['text-decoration'] = 'underline';
    // document.getElementById('upcoming-events').style['text-decoration-color'] = '#404040';
}

function displayPastEvents() {
    removeTicketsDisplay();
    displayTickets(past_tickets);
    document.getElementById('past-events').style.color = "#404040";
    document.getElementById('past-events').style['text-decoration'] = 'underline';
}

function displayTickets(displayed_tickets) {
    for (var i = 0; i!=displayed_tickets.length; ++i) {
        var ticket_info = displayed_tickets[i];

        var ticket = document.createElement("div");
        ticket.className = 'ticket';

        var img_container = document.createElement('div');
        img_container.id = 'ticket-image'+i;
        img_container.className = 'ticket-image-container';
        var img = document.createElement('img');
        img.src = ticket_info['image'];
        img_container.appendChild(img);
        ticket.appendChild(img_container);
        // resizeImage('ticket-image'+i, 0);

        var info_container = document.createElement('div');
        info_container.className = 'ticket-info-container';
        ticket.appendChild(info_container);

        var title = document.createElement('h5');
        title.innerHTML = ticket_info['title'];
        info_container.appendChild(title);

        var date = document.createElement('p');
        date.innerHTML = '<i class="fa fa-calendar" aria-hidden="true"></i> ' + ticket_info['date'];
        info_container.appendChild(date);

        var location = document.createElement('p');
        location.innerHTML = '<i class="fa fa-map-marker" aria-hidden="true"></i> ' + ticket_info['location'];
        info_container.appendChild(location);

        var order = document.createElement('p');
        order.innerHTML = 'Order # ' + ticket_info['order_number'];
        order.style.color = 'grey';
        info_container.appendChild(order);

        var btn = document.createElement('div');
        btn.id = 'btn' + i;
        btn.className = 'ticket-btn';
        btn.innerHTML = 'View Details';
        btn.addEventListener('click', function(){
            displayTicketDetail(displayed_tickets, (this.id)[this.id.length-1]);
        });
        info_container.appendChild(btn);

        // var type_price = document.createElement('p');
        // type_price.innerHTML = ticket_info['type'] + '($' + ticket_info['price'] + ') &times ' + ticket_info['quantity'];
        // info_container.appendChild(type_price);

        ticket.appendChild(img_container);
        ticket.appendChild(info_container);
        document.getElementById("tickets").appendChild(ticket);
    }
}

function removeTicketsDisplay() {
    var el = document.getElementById("tickets");
    while( el.hasChildNodes() ){
        el.removeChild(el.lastChild);
    }

    document.getElementById('upcoming-events').style.color = '#999999';
    document.getElementById('past-events').style.color = '#999999';

    document.getElementById('upcoming-events').style['text-decoration'] = 'none';
    document.getElementById('past-events').style['text-decoration'] = 'none';
}

function displayTicketDetail(displayed_tickets, i) {
    var ticket_info = displayed_tickets[i];

    var ticket = document.getElementById("ticket-popup-content");
    var qr = document.createElement('img');
    if (ticket_info['quantity'] > 1) {
        var plr = 's';
    } else {
        var plr = '';
    }

    var detail = document.createElement('p');
    detail.innerHTML = '$' + ticket_info['price'] + ' ' + ticket_info['type'] + ' Ticket &times ' + ticket_info['quantity'];
    ticket.appendChild(detail);

    var qr_str = ticket_info['title'] + " - " + ticket_info['quantity'] + " " + ticket_info['type'] + " ($" + ticket_info['price'] + ") Ticket" + plr;
    qr.src = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=" +  qr_str + "&choe=UTF-8";
    ticket.appendChild(qr);

    var btn = document.createElement('div');
    btn.className = 'ticket-btn';
    btn.innerHTML = 'Cancel Ticket';
    btn.addEventListener('click', function(){
        if (confirm("Please confirm cancellation for Event: \n" + ticket_info['title'])) {
            console.log("js: " + ticket_info['reg_id']);
            $.ajax({
                data: {
                    reg_id: ticket_info['reg_id']
                },
                url: 'customerTicketCancellation.php',
                method: 'POST',
                success: function(msg) {
                    alert('Ticket Successfully Canceled.');
                    window.location = "#tickets-tab";
                    location.reload();
                }
            });
        }
    });
    ticket.appendChild(btn);

    window.location.href = '#ticket-popup';
}

function removeTicketDetailDisplay() {
    var el = document.getElementById("ticket-popup-content");
    while( el.hasChildNodes() ){
        var b = el.lastChild;
        el.removeChild(b);
        b = null;
    }
}
