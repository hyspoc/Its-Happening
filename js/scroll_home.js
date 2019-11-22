/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(function() {
  var number_of_card = 15, card_html = '';

    $.ajax({
            method:"POST",
            url: "Search.php",
            data: { orderfromtoday: 1 }
        }).done(function(data) {
            var searchData = $.parseJSON( data);

            dataLength = searchData.length;
            if( dataLength == 0){
                $(".searchResult").html('No results found. <a href="browse.php">View all</a>');
            }
            else{
                for (var i = 0; i < dataLength; i++) {
                    var extra_info = {
                        created_by: 'Created by Its Happening',
                        last_access: `${i*7+2} days ago`,
                        hit_count: `${i*112+2} times`
                      }
                    var event_info = searchData[i];
                    var url = "";
                     card_html += (sm_card_html(`Event ${i+1}`, url, extra_info, event_info));

                }
                 $('#items').append(card_html);
            }
        });


    /* for(var i=0; i<number_of_card; i++) {
      var extra_info = {
        created_by: 'Created by Its Happening',
        last_access: `${i*7+2} days ago`,
        hit_count: `${i*112+2} times`
      }
      card_html += (sm_card_html(`Event ${i+1}`, 'https://picsum.photos/400/300?image='+(i*13), extra_info));
  }*/

  $('#sm_left_arrow, #sm_right_arrow').on('click', function() {
        var card_width = $('.sm_card').width() + 6,
        target_renderer = $(this).siblings('.sm_horizontal_list_renderer'),
        curr_translate = parseInt(target_renderer.attr('c_translate')),
        positive_negetive_multiplier = $(this).attr('id') == 'sm_left_arrow' ? 1 : -1,
        next_translate = curr_translate + card_width * positive_negetive_multiplier,
        no_of_cards = target_renderer.find('.sm_card').length,
        no_of_visible_cards = parseInt($(this).parent().width() / card_width);
    target_renderer.css('transform', `translateX(${next_translate}px)`).attr('c_translate', next_translate);
    if(next_translate >= 0) {
        target_renderer.siblings('#sm_left_arrow').hide();
        target_renderer.siblings('#sm_right_arrow').show();
    } else if(next_translate <= (no_of_cards - no_of_visible_cards) * -card_width) {
        target_renderer.siblings('#sm_left_arrow').show();
        target_renderer.siblings('#sm_right_arrow').hide();
    } else {
        target_renderer.siblings('#sm_left_arrow').show();
        target_renderer.siblings('#sm_right_arrow').show();
    }
  });
});
function sm_card_html(tab_name, image_url, extra_info, event_info) {
    var newString = "";
    if((event_info.name).length > 15){
        newString = (event_info.name).substring(0,14)+"...";
    }else{
        newString = event_info.name;
    }

    /* convert military time to standard time */
    // var std_res = event_info.date;
    // var [std_date, std_time] = std_res.split(" ");
    // var [std_hour, std_min, std_sec] = std_time.split(":").map(parseFloat);
    //
    // if (std_hour > 12) {
    //     std_hour -= 12;
    //     std_res = std_date + " " + [std_hour, std_min, std_sec].map(function(x) {return ("0" + x).slice(-2);}).join(":") + " PM";
    // } else {
    //     std_res += " AM";
    // }
  var eventPage = "event.php?event_id="+event_info.event_id;
  var card_template =
    `<div class="sm_card card">
        <div class="card-image waves-effect waves-block waves-light">
          <img class="activator" src="${event_info.image}">
        </div>
        <div class="card-content">
          <span class="card-title grey-text text-darken-4">${newString}<i class="activator material-icons right">info</i></span>
          <span>${event_info.date} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span><br/>
        <p style="font-size:12px;font-weight:500;"> Created By: ${event_info.organizer}<p>
        </div>
        <div class="card-reveal">
          <span class="card-title grey-text text-darken-4">${event_info.name}<i class="material-icons right">close</i></span>
          <p>${event_info.description}</p>
         <a href="${eventPage}">Know More</a>
        </div>
    </div>`;
  return card_template;
}
