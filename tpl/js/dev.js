window.onscroll = function() {
  var scroll = window.pageYOffset || window.scrollTop;
  var dev_menu = ge("dev_menu");
        
  if (dev_menu == null) return;
    
  if (scroll > 400) {
    dev_menu.classList.add("dev-menu-fixed");
  } else {
    dev_menu.classList.remove("dev-menu-fixed");
  }
}