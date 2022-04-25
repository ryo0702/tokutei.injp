import $ from "jquery";

// Document Completed
window.addEventListener('DOMContentDelayed', () => {
    const tnsCarousel = document.querySelectorAll('.nutrail-slider');
    if (tnsCarousel.length > 0) {
        import(/* webpackChunkName: "tiny-slider" */'../vendor/tiny-slider/tiny-slider').then(({tns}) => {
            tnsCarousel.forEach(slider => {
                const config   = slider.getAttribute('data-tns') ? JSON.parse(slider.getAttribute('data-tns')) : {},
                      defaults = {
                          container   : slider,
                          autoWidth   : true,
                          mouseDrag   : true,
                          loop        : true,
                          lazyload    : true,
                          swipeAngle  : false,
                          nav         : false,
                          gutter      : 0,
                          controlsText: [
                              '<span class="screen-reader-text">arrow prev</span><svg xmlns="http://www.w3.org/2000/svg" width="40.157" height="70.265" viewBox="0 0 40.157 70.265"><g id="arrow" transform="translate(560.664 -74.689) rotate(-90)"><path id="Path_7" data-name="Path 7" d="M2,30.085,30.061,2,58.123,30.085" transform="translate(-139.883 -557.664)" fill="none" stroke="inherit" stroke-linecap="round" stroke-linejoin="round" stroke-width="10"/></g></svg>',
                              '<span class="screen-reader-text">arrow next</span><svg xmlns="http://www.w3.org/2000/svg" width="40.157" height="70.265" viewBox="0 0 40.157 70.265"><g id="arrow" transform="translate(-520.508 144.954) rotate(90)"><path id="Path_7" data-name="Path 7" d="M2,30.085,30.061,2,58.123,30.085" transform="translate(-139.883 -557.664)" fill="none" stroke="inherit" stroke-linecap="round" stroke-linejoin="round" stroke-width="10"/></g></svg>',
                          ],
                      };
                tns($.extend(defaults, config));
            });
        })
    }
});