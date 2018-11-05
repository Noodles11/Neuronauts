beh = '#FF0000';
zab = '#FFCF00';
neu = '#3415B0';
ewo = '#00CC00';
hom = '#00A8AF';

window.Cathegory = 'hom';

$( document ).ready( function(){
	setTimeout(System.rmCBA(),100);
	System.init();
});

var System = {

	init: function(){

		//this.menuAction();
	},

	setArtColors: function(){

		$('ul.news').children('li.title').each(function(i,el){
			el.style.color = window[el.parentElement.getAttribute('dzial')];
		});
		$('ul.news').children('li.more').each(function(i,el){
			el.style.backgroundColor = window[el.parentElement.getAttribute('dzial')];
		});
	},

	setMainMenuColors: function(){
			
		$('ul#menu').find('li').each(function(i,el){
			el.style.backgroundColor = window[el.id];
		}.bind(this));
	},

	setDockColor: function( id ){
			
		$('#menuBar')[0].style.backgroundColor = window[id];
	},
	setDockLiColor: function(){

		$('.menu > a > li').each(function(i,el){
			el.style.color = window[el.id];
		}.bind(this));
	},

	rmCBA: function(){

		if( $('#reklamacba') ){ 
			$('#reklamacba').remove(); 
		}

		if( $('div.cbalink') ){
			$('div.cbalink').remove();
		}
	},

	menuAction: function(){

		$('#content')[0].style.marginTop = '50px';

		var bar = $('#menuBar');
		bar.css('top','-150px');
		
		bar.hover(function(e){
			bar.animate({top:'0px'},100);
		}.bind(this),function(e){
			bar.animate({top:'-150px'},100);
		}.bind(this));
	}

}