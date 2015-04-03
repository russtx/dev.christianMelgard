// Switches out the main site nav#access with a select box
// Minimizes nav#access on mobile devices
// Now lets load the JS when the DOM is ready
jQuery(document).ready(function($){

  // Create the dropdown base
  $("<select />").appendTo("nav#access");
  
  // Create default option "Go to..."
  $("<option />", {
     "selected": "selected",
     "value"   : "#",
     "text"    : "Go to..."
  }).appendTo("nav#access select");
  
  // Populate dropdown with menu items
  $("nav#access .menu a").each(function() {
   var el = $(this);
   $("<option />", {
       "value"   : el.attr("href"),
       "text"    : el.text()
   }).appendTo("nav#access select");
  });
  
 // To make dropdown actually work
 // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
  $("nav#access select").change(function() {
    window.location = $(this).find("option:selected").val();
  });
	
	// style select boxes
  if (!$.browser.opera) {

    $('nav#access select').each(function(){
      var title = $(this).attr('title');
      if( $('option:selected', this).val() != ''  ) title = $('option:selected',this).text();
      $(this)
	      .css({'z-index':10,'opacity':0,'-khtml-appearance':'none'})
	      .after('<span class="select">' + title + '</span>')
	      .change(function(){
          val = $('option:selected',this).text();
          $(this).next().text(val);
         })
    });

  };

});
