var paypal_price;
var date;
var event_name;
var desc;
var event_venue;
var info;
var event_type;
var website;
var twitter_link;
var facebook_link;
var latitude;
var longitude;
var featured;
var tickets = [];

function set_featured(t) {
    checkoutValues();
    saveValue(t);
}

function saveValue(e){
    var id = e.id;
    var val = e.value;
    localStorage.setItem(id, val);
}

function getSavedValue  (v){
    if (localStorage.getItem(v) === null) {
        return "";
    }
    return localStorage.getItem(v);
}

function checkoutValues() {
    if (document.getElementById("featured").checked) {
        document.getElementById("checkout-subtotal").textContent = "$150.00";
        document.getElementById("checkout-tax").innerHTML = "$10.50";
        document.getElementById("checkout-total").innerHTML = "$160.50";
    } else {
        document.getElementById("checkout-subtotal").innerHTML = "$100.00";
        document.getElementById("checkout-tax").innerHTML = "$7.00";
        document.getElementById("checkout-total").innerHTML = "$160.50";
    }
}

function readURL(input, id,size) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $("#" + id).attr("src", e.target.result);
            $("#" + id).attr("width", size);
        };

        reader.readAsDataURL(input.files[0]);
    }

}

function setTicketValue(eid) {
    quantity = document.getElementById(eid+'-avail').value;
    price = document.getElementById(eid+'-price').value;

    if (document.getElementById(eid).checked && parseFloat(quantity)>0 && parseFloat(price)>0) {
        tickets.push({
            type: eid,
            quantity: quantity,
            price: price
        });
    }
}

function setValues(){
    var geocoder = new google.maps.Geocoder();

    event_venue = document.getElementById("eventvenue").value;
    geocoder.geocode( {'address': document.getElementById("eventvenue").value}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            latitude = results[0].geometry.location.lat();
            longitude = results[0].geometry.location.lng();

            event_name = document.getElementById("eventname").value;
            date = document.getElementById("date").value;
            date += " " + document.getElementById("time").value;
            desc = document.getElementById("description").value;
            desc = desc.replace(/'/g, "\\'");
            desc = desc.replace(/"/g, '\\"');
            info = document.getElementById("add_info").value;
            info = info.replace(/'/g, "\\'");
            info = info.replace(/"/g, '\\"');
            event_type = document.getElementById("job").value;
            website = document.getElementById("event_website").value;
            twitter_link = document.getElementById("twitterlink").value;
            facebook_link = document.getElementById("facebooklink").value;
            event_venue = document.getElementById("eventvenue").value;

            setTicketValue('general');
            setTicketValue('vip');
            setTicketValue('student');

            if (document.getElementById("featured").checked)  {
                paypal_price = '160.5';
                featured = true;
            } else {
                paypal_price = '107';
                featured = false;
            }
        } else {
            alert("Sorry, we couldn't verify your address, please try again.");
            window.location = '#';
        }
    });
    window.location = "#organizerPayPopup";
}

function clearValues() {
    paypal_price = '107';
    date = '';
    event_name = '';
    desc = '';
    event_venue = '';
    info = '';
    event_type = '';
    website = '';
    twitter_link = '';
    facebook_link = '';
    latitude = '';
    longitude = '';
    featured = '';
    tickets = [];
}

// function test(){
//     $.ajax({
//         data: {
//             eventname: event_name,
//             date: date,
//             description: desc,
//             add_info: info,
//             eventvenue: event_venue,
//             type: event_type,
//             event_website: website,
//             twitterlink: twitter_link,
//             facebooklink: facebook_link,
//             event_amt: paypal_price,
//             latitude: latitude,
//             longitude: longitude,
//             tickets: tickets
//         },
//         url: 'event-requestsubmitted.php',
//         method: 'POST',
//         success: function(msg) {
//             alert('Your payment has been processed.');
//             window.location = "#";
//         }
//     });
// }

function paypalCheckoutOrganizer() {

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
                        eventname: event_name,
                        date: date,
                        description: desc,
                        add_info: info,
                        eventvenue: event_venue,
                        type: event_type,
                        event_website: website,
                        twitterlink: twitter_link,
                        facebooklink: facebook_link,
                        event_amt: paypal_price,
                        latitude: latitude,
                        longitude: longitude,
                        tickets: tickets,
                        featured: featured
                    },
                    url: 'event-requestsubmitted.php',
                    method: 'POST',
                    success: function(msg) {
                        alert('Your payment has been processed.');
                    }
                });
                window.location = "#";
            });
    }

    }, '#paypal-button');
}
