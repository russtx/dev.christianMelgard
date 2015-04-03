<?php
global $theme_options, $imageheight;
	$imgsepdis = 0;
	if(isset($theme_options['gpp_base_separation_distance'])){
		$imgsepdis = ($theme_options['gpp_base_separation_distance']);
	}

//$imageheight = get_option( 'large_size_h');
$imageratio = ($imageheight/50);

$doc_ready_script = '
	<script type="text/javascript">
		jQuery(document).ready(function(){
						jQuery("#mainholder").css("max-width","100%");
						jQuery("#mainindex").css("width","100%");
						jQuery("#mainholder #holder div.singleitem").css({"margin-left":'.$imgsepdis.'});
						jQuery("#mainholder #holder div.singleitem").last().addClass("last").css({"border-right":"'.$imgsepdis.'px"});
						jQuery("#mainindex #imagediv img").css({"margin-left":'.($imgsepdis/$imageratio).'});
						jQuery("#mainindex #imagediv img").last().css({"margin-right":'.($imgsepdis/$imageratio).'});
						totalwidth = jQuery("#holder").width(); // Total large image width
						totalimages = jQuery("#holder .singleitem").size();
						totalwidth = totalwidth+('.($imgsepdis).')*(totalimages+1);
						jQuery("#holder").css({"width":totalwidth});
						sliderwidth = '.($imgsepdis/$imageratio).';
						jQuery("#imagediv img").each(function(){
							sliderwidth = sliderwidth+parseInt(jQuery(this).attr("width"))+'.($imgsepdis/$imageratio).';
						});

						jQuery(".end").css("right","0");
						if(totalimages<=1){
							jQuery("#mainholder").addClass("fixwidth");
							jQuery("#mainholder").css("width","960px");
							jQuery("a.leftnav,a.rightnav").hide();
						}
						variablechange(); //for initialization before window resize	is called
						function variablechange(){
							tempslidedist = new Array();
							slidedist = new Array();
							screenwidth = jQuery(window).width(); // Visible screen width
							handlewidth = ((screenwidth/'.$imageratio.')-6);	// width of the slider handle according to the width of the screen
							screenmid = (screenwidth)/2; // Middle of visible screen
							sliderparts = 1000; // slider length divided into 1000 sections
							tempval = (screenmid*sliderparts*'.$imageratio.')/(totalwidth); // The total distance the slider has moved when it reaches the middle of the screen.
							mval = totalwidth*((1/sliderparts)/'.$imageratio.'); // multiplying factor for the slider handle
							holdermulti = (totalwidth-screenwidth+10)/sliderparts; // Multiple value with which the main images move
							halfhandlewidth = handlewidth/2;
							jQuery("#imagediv").css("width",(sliderwidth)+"px");
							indexwidth = (sliderwidth-handlewidth-5);
							jQuery("#index").css("width",indexwidth+"px");
							divratio = (indexwidth)/sliderparts;
							if(sliderwidth > screenwidth){
								jQuery("#index").css("margin-left","71px");
							}else{
								jQuery("#index").css("margin-left","");
							}
							slidespeed = (sliderparts/(sliderwidth))*95;
							if(sliderwidth<(handlewidth+10) || totalimages == 0){ //+10 is added to make the difference larger so when they are almost same, the error doesnot takeplace
								jQuery("#mainindex").hide();
								jQuery(".slider-navigation a.leftnav, .slider-navigation a.rightnav").hide();
							} else{
								jQuery("#mainindex").show();
								jQuery(".slider-navigation a.leftnav, .slider-navigation a.rightnav").show();
							}

							for(var i=0;i<totalimages;i++){
								if(i==0){
									tempslidedist[i] = ((jQuery("#imagediv img:eq("+(i)+")").width()-((handlewidth+3)/2))+(jQuery("#imagediv img:eq("+(i+1)+")").width()/2) + '.($imgsepdis/$imageratio).');
								}else{
									tempslidedist[i] = (tempslidedist[i-1] + jQuery("#imagediv img:eq("+(i)+")").width()/2 + jQuery("#imagediv img:eq("+(i+1)+")").width()/2 + '.($imgsepdis/$imageratio).');
								}
								slidedist[i] = Math.round(((tempslidedist[i]))/divratio);
							}
						}

						jQuery(".imgexcerpt").hide();

						jQuery("div.imglink").click(function(e){ //Toggling the show/hide the img excerpt link

							thisimgwidth = jQuery(this).parent().find("img").width();

							if(thisimgwidth<355){
								exceptwidth = (.85*thisimgwidth);
							}else{
								exceptwidth = 340;
							}
							jQuery(this).parent().siblings().find(".imgexcerpt").fadeOut("fast")
								.end()
								.find("img").fadeTo("fast", 1)
								.end()
								.find(".imglink").addClass("show");

							if(jQuery(this).hasClass("show")){
								jQuery(this).parent().find(".imgexcerpt").css({"width":exceptwidth}).fadeIn("fast");
								jQuery(this).parent().find("img").fadeTo("fast", .3);
								jQuery(this).removeClass("show");
							}else{
								jQuery(this).parent().find(".imgexcerpt").css({"width":exceptwidth}).fadeOut("fast");
								jQuery(this).parent().find("img").fadeTo("fast", 1);
								jQuery(this).addClass("show");
							}

						});

						jQuery("#index").slider({
							max		:	sliderparts,
							animate	:	true,
							step	:	1,
							change	:	ifSliderChange,
							slide	:	ifSliderSlide
						});
						jQuery("#index").slider("value",(0));
						jQuery("#index").css("z-index","99");
						mainfunctions(); //for initialization before window resize
						function mainfunctions(){
							jQuery("#index .ui-slider-handle").css("width",(handlewidth)+"px");
							if(sliderwidth < screenwidth){
								jQuery("#index .ui-slider-handle").css("margin","0 -" + (handlewidth/2 + 3) + "px");
							}

						}

						animating = false;
						click = -1;

						jQuery("body").on("click", ".leftnav", function(){
							if(!animating ){
								if(click>=0){click--;}
								var sliderpos = jQuery("#index").slider("value");
								var flag=0;
								for(var j=totalimages;j>=0;j--){
									if((sliderpos>slidedist[(j)]) && flag==0){
										click=j;
										flag=1;
									}
								}
								if(click<0){
									jQuery("#index").slider("value",(0));
								}else{
									jQuery("#index").slider("value",(slidedist[click]));
								}
								animating = true;
							}
						});

						jQuery("body").on("click", ".rightnav", function(){
							if(!animating ){
								click++;
								var sliderpos = jQuery("#index").slider("value");
								var flag=0;
								for(var j=0;j<totalimages;j++){
									if((slidedist[(j)]>sliderpos) && flag==0){
										click=j;
										flag=1;
									}
								}
								if(sliderpos >= sliderparts){
									jQuery("#index").slider("value",(0));
									click = -1;
								}else{
									jQuery("#index").slider("value",(slidedist[click]));
								}
								animating = true;
							}
						});
						jQuery(".end").css("z-index","99");
						jQuery(".start").css("z-index","99");
						jQuery(".end").click(function(){
							jQuery("#index").slider("value",(sliderparts));
						});
						jQuery(".start").click(function(){
							jQuery("#index").slider("value",(0));
						});

						jQuery(window).resize(function() {
							variablechange();
							mainfunctions();
						});

					function ifSliderChange(e, ui) {

						jQuery("#mainindex").animate({scrollLeft: (((ui.value-tempval)*mval)) }, 500);
						jQuery("#mainholder").animate({scrollLeft: (ui.value * holdermulti) }, 500,function(){animating = false;});
					}

					function ifSliderSlide(e, ui) {
						jQuery("#mainholder").animate({scrollLeft: (ui.value * holdermulti) }, 500).stop();
					}
			});
			</script>
			';
	echo $doc_ready_script;
?>