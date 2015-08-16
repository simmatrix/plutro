$(document).ready(function () {
	console.log("Plutro is ready");

	exercise5();

	function exercise1(){
		// New datetime
		var datetime1	= '2001-01-01 10:00:00';
		var datetime2	= '2001-01-01 11:00:00';
		datetime1		= splitDatetime( datetime1 );
		datetime2		= splitDatetime( datetime2 );

		// Lets start checking
		var pastFuture 	= checkPastFuture( datetime1, datetime2 );
		var result 		= calculate( datetime1, datetime2 );

		var year	= result['year'];
		var month	= year%1*12;
		var day		= month%1*30;
		var hour	= day%1*24;
		var minute	= hour%1*60;
		var second	= minute%1*60;

		console.log( Math.floor(year) + ' year(s)' );
		console.log( Math.floor(month) + ' month(s)' );
		console.log( Math.floor(day) + ' day(s)' );
		console.log( Math.floor(hour) + ' hour(s)' );
		console.log( Math.floor(minute) + ' minute(s)' );
		console.log( Math.ceil(second) + ' second(s)' );
		console.log( pastFuture );

		function splitDatetime( datetime ){
			// Segregate datetime
			var datetime	= datetime.split( ' ' );
			var date		= datetime[0];
			var time		= datetime[1];

			// Segregate date
			var splitDate	= date.split( '-' );
			var year		= splitDate[0];
			var month		= splitDate[1];
			var day			= splitDate[2];

			// Segregate time
			var splitTime	= time.split( ':' );
			var hour		= splitTime[0];
			var minute		= splitTime[1];
			var second		= splitTime[2];
			return {year:year, month:month, day:day, hour:hour, minute:minute, second:second};
		}
		function checkPastFuture( datetime1, datetime2 ){
			var result 	= '';

			// We need to put into array form to get it's index.
			var arr1 	= [datetime1['second'], datetime1['minute'], datetime1['hour'], datetime1['day'], datetime1['month'], datetime1['year']];
			var arr2 	= [datetime2['second'], datetime2['minute'], datetime2['hour'], datetime2['day'], datetime2['month'], datetime2['year']];
			for( var i = 0; i<arr1.length; i++ ){
				temp = compare( arr1[i], arr2[i] );
				// Update global result
				if( temp != 'same' ){ // We do not want the last param to be the determine factor.
					result = temp;
				}
			}
			return result;
		}
		function calculate( datetime1, datetime2 ){
			var seconds1 = getSeconds( datetime1 );
			var seconds2 = getSeconds( datetime2 );

			if( seconds1 > seconds2 ){
				var diff = seconds1 - seconds2;
			}
			if( seconds2 > seconds1 ){
				var diff = seconds2 - seconds1;
			}
			year	= diff / 60 / 60 / 24 / 365;
			month	= diff / 60 / 60 / 24 / 30;
			day		= diff / 60 / 60 / 24;
			return {year:year, month:month, day:day};
		}
		function compare( arg1, arg2 ){

			// console.log(arg1);
			// console.log(arg2);

			if( arg2 > arg1 ){
				return 'later';
			}
			if( arg1 > arg2 ){
				return 'ago';
			}
			if( arg1 == arg2 ){
				return 'same';
			}	
		}
		function getSeconds( datetime ){
			var seconds = parseInt(datetime['year'])*365*24*60*60;
			seconds += parseInt(datetime['month'])*30*24*60*60;
			seconds += parseInt(datetime['day'])*24*60*60;
			seconds += parseInt(datetime['hour'])*60*60;
			seconds += parseInt(datetime['minute'])*60;
			seconds += parseInt(datetime['second']);

			return seconds;
		}
	}
	function exercise2(){
		var temp = multiplier( 3 );
		var temp2 = temp(2);
		console.log(temp2);

		// Cannot change anything from here onwards
		function multiplier(factor){
			return function(number){
				return number * factor;
			};
		}
	}
	function exercise3(){
		var temp = wrapValue(1);
		var temp2 = temp();
		console.log(temp2);

		// Cannot change anything from here onwards
		function wrapValue(n){
			var localVariable = n;
			return function(){
				return localVariable;
			};
		}
	}
	function exercise4(){
		// "F" capital is a constructor for declaring a new function.
		add = Function( 'a', 'b', 'return a+b' );
		console.log( add(1, 2) );
	}
	function exercise5(){
		// Finding similarity score between 2 words.
		// Link: https://en.wikipedia.org/wiki/Levenshtein_distance
		// Demo: http://www.let.rug.nl/~kleiweg/lev/

	}

	$('#unixTime').keyup(function(e){
		if(e.keyCode == 13) {
			$('#unixTimeBtn').click();
		}
	});
	$('#unixTimeBtn').click(function(){
		var value 		= $('#unixTime').val();
		var timezone 	= $('#unixTimezone').val();

		if( value.length <= 0 ) {
			$('#unixTime').parent('.input-group').addClass('has-error');
			$('#unixTimeFormat').fadeOut();
		}else{
			$('#unixTime').parent('.input-group').removeClass('has-error');

			var params	= {
				value:value,
				timezone:timezone
			};
			var promise = ajax( 'ajaxUnixReader', params );
			promise.success(function (data) {
				$('#unixTimeFormat').fadeIn();
				$('#unixTimeResult').html(data).hide();
				$('#unixTimeResult').fadeIn();
			});
		}
	});
	$('#randomCharacterBtn').click(function(){
		$(this).addClass("btn-primary");
		if( $('#randomWordBtn').hasClass('btn-primary') ){
			$('#randomWordBtn').removeClass('btn-primary')
		}
	});
	$('#randomWordBtn').click(function(){
		$(this).addClass("btn-primary");
		if( $('#randomCharacterBtn').hasClass('btn-primary') ){
			$('#randomCharacterBtn').removeClass('btn-primary')
		}
	});
	$('#randomTextBtn').click(function(){
		var amount 			= $('#randomTextAmount').val();
		var randomCharacter = $('#randomCharacterBtn').hasClass('btn-primary');
		var randomWord 		= $('#randomWordBtn').hasClass('btn-primary');

		if( amount.length <= 0 ){
			$('#randomTextAmount').parent('.input-group').addClass('has-error');
		}else{
			$('#randomTextAmount').parent('.input-group').removeClass('has-error');

			var params	= {amount:amount};
			if( randomCharacter ){
				var promise = ajax( 'ajaxRandomCharacters', params );
			}
			if( randomWord ){
				var promise = ajax( 'ajaxRandomWords', params );
			}
			if( randomCharacter || randomWord ){
				promise.success(function (data) {
					var text = data.toLowerCase();
					text = text.substr(0,1).toUpperCase()+text.substr(1);
					$('#randomTextbox').html(text);
				});
			}
		}
	});

	var colorBtn = new ZeroClipboard( $('.colorBtn') );
	colorBtn.on( 'ready', function(event) {
		colorBtn.on( 'copy', function(event) {
			var value = $(event.target);
			event.clipboardData.setData('text/plain', value.text());
			// event.clipboardData.setData('text/plain', event.target.innerHTML);
		});

		colorBtn.on( 'aftercopy', function(event) {
			// console.log('Copied text to clipboard: ' + event.data['text/plain']);
		});
	});
	colorBtn.on( 'error', function(event) {
		// console.log( 'ZeroClipboard error of type "' + event.name + '": ' + event.message );
		ZeroClipboard.destroy();
	} );
	$('.colorBtn').click(function(){
		var text 		= $(this).text();
		var colorValue 	= $(this).find('span');

		// Disable all buttons prevent spam
		$('.colorBtn, #hexBtn, #rgbBtn').addClass('disabled');

		colorValue.html('Copied').hide();
		colorValue.fadeIn(500, function(){
			colorValue.text(text);
			$('.colorBtn, #hexBtn, #rgbBtn').removeClass('disabled');
		});
	});
	$('#hexBtn').on('click', function(){
		$(this).addClass("btn-primary");
		if( $('#rgbBtn').hasClass('btn-primary') ){
			$('#rgbBtn').removeClass('btn-primary')
		}

		$('.btn-red-ff6961 > span').text('#ff6961');
		$('.btn-green-77dd77 > span').text('#77dd77');
		$('.btn-blue-779ecb > span').text('#779ecb');
		$('.btn-brown-f1a55a > span').text('#f1a55a');
	});
	$('#rgbBtn').on('click', function(){
		$(this).addClass("btn-primary");
		if( $('#hexBtn').hasClass('btn-primary') ){
			$('#hexBtn').removeClass('btn-primary')
		}

		$('.btn-red-ff6961 > span').text('255,105,97');
		$('.btn-green-77dd77 > span').text('119,190,119');
		$('.btn-blue-779ecb > span').text('119,158,203');
		$('.btn-brown-f1a55a > span').text('241,165,90');
	});
	$('#countCharacterBtn').click(function(){
		$(this).addClass("btn-primary");
		if( $('#countWordBtn').hasClass('btn-primary') ){
			$('#countWordBtn').removeClass('btn-primary')
		}
	});
	$('#countWordBtn').click(function(){
		$(this).addClass("btn-primary");
		if( $('#countCharacterBtn').hasClass('btn-primary') ){
			$('#countCharacterBtn').removeClass('btn-primary')
		}
	});
	$('#countTextBtn').click(function(){
		var amount 			= $('#countTextbox').val();
		var countCharacter 	= $('#countCharacterBtn').hasClass('btn-primary');
		var countWord 		= $('#countWordBtn').hasClass('btn-primary');

		if( amount.length <= 0 ){
			// do something..
		}else{
			var params	= {amount:amount};
			if( countCharacter ){
				var promise = ajax( 'ajaxCountCharacters', params );
			}
			if( countWord ){
				var promise = ajax( 'ajaxCountWords', params );
			}
			if( countCharacter || countWord ){
				promise.success(function (data) {
					if(countCharacter)
						$('.countResult').text(data+' characters').hide().fadeIn();
					else
						$('.countResult').text(data+' words').hide().fadeIn();
				});
			}
		}
	});
}); // document ready end.

function ajax( ajaxFunction, params ){
	var path = '/ajax/' + ajaxFunction;
	return $.ajax({
		type: "POST",
		data: {
			func:ajaxFunction,
			param:params
		},
		url: path,
		success: function(data){
		}
	});
}
