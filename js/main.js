
function main() {

(function () {
   'use strict';
   
  	// $('a.page-scroll').click(function() {
    //     if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
    //       var target = $(this.hash);
    //       target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
    //       if (target.length) {
    //         $('html,body').animate({
    //           scrollTop: target.offset().top - 50
    //         }, 900);
    //         return false;
    //       }
    //     }
    //   });


    $('body').scrollspy({ 
        target: '.navbar-default',
        offset: 80
    });

	// Hide nav on click
  $(".navbar-nav li a").click(function (event) {
    // check if window is small enough so dropdown is created
    var toggle = $(".navbar-toggle").is(":visible");
    if (toggle) {
      $(".navbar-collapse").collapse('hide');
    }
  });
	
	
    // Nivo Lightbox 
    $('.portfolio-item a').nivoLightbox({
            effect: 'slideDown',  
            keyboardNav: true,                            
        });
    
    /* DELAYED MODAL */
    setTimeout(function(){
      if (getWithExpiry('intLock') === true){
        return
      }
      setWithExpiry('intLock',true,21600000); // 6 hours of TTL
      $('#interrupt-modal').modal('show');
    }, 5000);

		
    /* EVENT CLICK */
    /* $('.int-modal-body').click(function(e){
      if (getWithExpiry('intLock') === true){
        return
      }
      setWithExpiry('intLock',true,21600000); // 6 hours of TTL
      window.location.replace('https://wa.link/9ro9gc')
    }); */

}());


}
main();

// Function to set an item in localStorage with a TTL
function setWithExpiry(key, value, ttl) {
  const now = new Date();
  const item = {
      value: value,
      expiry: now.getTime() + ttl // TTL in milliseconds
  };
  localStorage.setItem(key, JSON.stringify(item));
}

// Function to retrieve an item from localStorage and check if it has expired
function getWithExpiry(key) {
  const itemStr = localStorage.getItem(key);
  if (!itemStr) {
      return null; // Item does not exist
  }
  const item = JSON.parse(itemStr);
  const now = new Date();
  if (now.getTime() > item.expiry) {
      localStorage.removeItem(key); // Remove the item if it has expired
      return null; // Item has expired
  }
  return item.value; // Return the value if it's still valid
}
