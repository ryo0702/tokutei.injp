import $ from "jquery";

$(document).on('click', '.view_sp .humberger', function (e) {
    e.preventDefault();

    const button = $(this),
          wrap   = button.closest('.view_sp');

    button.toggleClass('active');
    wrap.children('.group_menu').slideToggle();
});

$(document).on('click', '.group_menu .carets', function (e) {
    e.preventDefault();

    const button = $(this),
          menu   = button.closest('.menu-item');

    button.toggleClass('active');
    menu.children('.sub-menu').slideToggle();
});