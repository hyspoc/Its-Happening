/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.onload = function () {
   // addMenu();
};

function addMenu() {
    try {
        var menuHeaderTag = document.getElementsByClassName('global-header')[0];
        var iDiv = document.createElement('div');
        iDiv.className = "global-header-quicklinks";
        var menuList = ['About US', 'FAQ', 'Browse', 'Create Event', 'Profile', 'Settings', 'Sign Up', 'Sign Out'];
        var actionItems = ['#', '#', 'browse.php', '#', '#', '#', 'login.php', 'login.php'];
        var ulist = document.createElement('ul');
        ulist.style['list-style-type'] = none;
        ulist.style['margin'] = 0;
        ulist.style['padding'] = 0;
        ulist.style['overflow'] = hidden;
        ulist.style['background-color'] = white;
        for (var i = 1; i < 9; i++) {
            var menu = document.createElement('li');
            var item = document.createElement('label');
            item.style['float'] = right;
            item.style['a']['hover'] =
            item.textContent = menuList[i - 1];
            menu.appendChild(item);
//            menu.href = actionItems[i-1];
            iDiv.appendChild(menu);
        }
        menuHeaderTag.appendChild(iDiv);
    } catch (e) {
        console.log(e);
    }
}
