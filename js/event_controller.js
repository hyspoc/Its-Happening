var paypal_price = '0.00';
var order_detail = '';
var purchase_ticket_ids = [];
var purchase_ticket_qtys = [];

window.onload = function () {
    addUserMarker(false);
    addMarker(lat,lng,name,type,true);
}

function showBookTickets() {
    window.location.href = '#bookTicketsPopup';
}

function updateTicketQuantity(ticket, n) {
    var quantity = parseInt(document.getElementById("ticket-quantity"+ticket).textContent);
    var quantity_ori = quantity;

    var ticket_price = document.getElementById("ticket-price"+ticket).textContent;
    if (ticket_price == "Free") {
        ticket_price = 0;
    } else {
        ticket_price = parseFloat(ticket_price.substring(1, ticket_price.length));
    }

    var total_price = parseFloat(document.getElementById("subtotal").textContent);

    quantity += n;
    if (quantity < 0) { quantity = 0; }

    total_price += (quantity - quantity_ori) * ticket_price;

    if (total_price < 0) { total_price = 0; }

    document.getElementById("ticket-quantity"+ticket).innerHTML = quantity;
    document.getElementById("subtotal").innerHTML = total_price.toFixed(2);
}

function setGuestEmail() {
    user_email = document.getElementById("guestEmail").value;
    getOrderDetailsPopUp();
}

function getOrderDetailsPopUp() {
    if (user_email == '') {
        window.location.href = '#guestPopup';
    } else {
        displayOrderDetails();
        window.location.href = '#checkoutPopup';
    }
}

function displayOrderDetails() {
    var i = 0;

    order_detail = '';
    while (document.getElementById("ticket-quantity"+i)) {
        var type = document.getElementById("ticket-type"+i).textContent;
        var qty = document.getElementById("ticket-quantity"+i).textContent;
        var price = document.getElementById("ticket-price"+i).textContent;

        if (parseInt(qty) == 0) {
            i++;
            continue;
        }

        purchase_ticket_ids.push(tickets[i]['ticket_id']);
        purchase_ticket_qtys.push(parseInt(qty));

        var content = document.createElement("p");
        var ticket_detail = document.createElement("span");
        var ticket_subtotal = document.createElement("span");

        ticket_detail.style.float = "left";
        ticket_detail_text = qty + " " + type + " Ticket";

        if (parseInt(qty) > 1) {
            ticket_detail_text += "s";
        }

        order_detail += '<p>' + ticket_detail_text + '</p>';
        ticket_detail.innerHTML = ticket_detail_text;
        ticket_subtotal.innerHTML = price + " &times; " + qty;

        content.appendChild(ticket_detail);
        content.appendChild(ticket_subtotal);
        document.getElementById("checkoutPopup-content").appendChild(content);
        i++;
    }

    var client_coupon = document.getElementById("coupon").value;
    var client_discount = 0;
    var client_subtotal = parseFloat(document.getElementById("subtotal").textContent);

    var coupon = document.createElement("span");
    coupon.innerHTML = client_coupon;

    var subtotal = document.createElement("span");
    subtotal.innerHTML = "$" + client_subtotal.toFixed(2);

    if (client_coupon != "") {
        // this is extreme un-ideal, but is the easiest way to demo with IU discount
        if (coupons.includes(client_coupon)) {
            if (client_coupon == 'IU95' && user_email.substr(-4) != '.edu') {
                coupon.innerHTML += " (Invalid)";
            } else {
                client_discount = discounts[coupons.indexOf(client_coupon)];
                document.getElementById("checkout-discount").style.display = "block";

                coupon.innerHTML += " (" + client_discount + "% OFF)";
            }
        } else {
            coupon.innerHTML += " (Invalid)";
        }

        document.getElementById("checkout-coupon").style.display = "block";
    }

    var discount = document.createElement("span");
    discount.innerHTML = "$" + (client_subtotal * client_discount / 100).toFixed(2);

    var tax = document.createElement("span");
    tax.innerHTML = "$" + (client_subtotal * (100 - client_discount) / 100 * .07).toFixed(2);

    var total = document.createElement("span");
    total.innerHTML = "$" + (client_subtotal * (100 - client_discount) / 100 * 1.07).toFixed(2);
    paypal_price = (client_subtotal * (100 - client_discount) / 100 * 1.07).toFixed(2);

    document.getElementById("checkout-coupon").appendChild(coupon);
    document.getElementById("checkout-subtotal").appendChild(subtotal);
    document.getElementById("checkout-discount").appendChild(discount);
    document.getElementById("checkout-tax").appendChild(tax);
    document.getElementById("checkout-total").appendChild(total);
}

function removeOrderDetails() {
    document.getElementById("checkoutPopup-content").innerHTML = "";
    document.getElementById("checkout-coupon").innerHTML = "Coupon: ";
    document.getElementById("checkout-discount").innerHTML = "Discount: ";
    document.getElementById("checkout-subtotal").innerHTML = "Subtotal: ";
    document.getElementById("checkout-tax").innerHTML = "Tax: ";
    document.getElementById("checkout-total").innerHTML = "Total: ";

    document.getElementById("checkout-coupon").style.display = "none";
    document.getElementById("checkout-discount").style.display = "none";

    order_detail = '';
    purchase_ticket_ids = [];
    purchase_ticket_qtys = [];
}

function paypalCheckout() {
    // Render the PayPal button
    paypal.Button.render({
        env: 'sandbox', // sandbox | production

        style: {
            label: 'checkout',
            size:  'medium',    // small | medium | large | responsive
            shape: 'pill',     // pill | rect
            color: 'gold',     // gold | blue | silver | black
            align: 'center'
        },

        // PayPal Client IDs - replace with your own
        // Create a PayPal app: https://developer.paypal.com/developer/applications/create

        client: {
            sandbox:    'AZDxjDScFpQtjWTOUtWKbyN_bDt4OgqaF4eYXlewfBP4-8aqX3PiV8e1GWU6liB2CUXlkA59kJXE7M6R',
            production: '<insert production client id>'
        },

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            amount: { total: paypal_price, currency: 'USD' }
                        }

                    ]
                }
            });
        },

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function() {
                $.ajax({
                    data: {
                        ticket_ids: purchase_ticket_ids,
                        ticket_qtys: purchase_ticket_qtys,
                        username: username,
                        dest_addr: user_email,
                        event_title: name,
                        order_detail: order_detail
                    },
                    url: 'ticketConfirmation.php',
                    method: 'POST',
                    success: function(msg) {
                        alert('Your payment has been processed, Please check your email for details.');
                        if (is_customer) {
                            window.location.href = "profile.php";
                        }
                    }
                });
                window.location = "#";
            });
        }

    }, '#paypal-button');
}
