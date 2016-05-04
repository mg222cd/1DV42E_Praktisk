/*"use strict";

var TrafficInfo = {
	map : undefined,
	categoryType : 4,
	locations : [],
	allCategories : [],

	init: function() {
		TrafficInfo.map = new Map(62.00, 15.00);
		TrafficInfo.getAllMessages();
		TrafficInfo.categoryBinding();
		TrafficInfo.messageBinding();
	},

	categoryBinding: function() {
		var that = this;
		$("#categoryType").on("click", "a", function() {
			TrafficInfo.map.deleteMarkers();
			that.categoryType = parseInt($(this).data('category-type'));
			that.renderCategoryTypeToList();
		});
	},

	messageBinding: function() {
		$("#trafficListing").on("click", "li", function(){
			var msgIndex = parseInt($(this).data('message-id'));
			google.maps.event.trigger(TrafficInfo.map.markers[msgIndex], 'click');
	  	});
	},

	getAllMessages: function() {
		$(document).ready(function () {
			$.ajax({
				type: 'GET',
				url: 'AjaxAction.php',
				dataType: 'json',
				data: {action: 'handleCache'}
			}).done(function (data) {
					var messages = data['messages'];
					TrafficInfo.renderMessages(messages);
				}).fail(function (jqXHR, textStatus) {
					console.log("Läsfel, status: " + textStatus);
				});
		});
	},

	renderMessages: function(messages) {
		for(var i = 0; i < messages.length; i++){
			var location = messages[i];
			location.marker = TrafficInfo.map.setMarker(location);
			this.locations.push(location);
		}
	},

	renderCategoryTypeToList : function() {
		var that = this;
		var trafficListing = "";
		for(var i = 0; i < this.locations.length; i++) {
			var locationByCategory = this.locations[i];		
			if(this.categoryType === 4 || this.categoryType === locationByCategory.category) {
				TrafficInfo.map.setMarker(locationByCategory);
				var index = TrafficInfo.map.markers.length - 1;
				trafficListing += '<li data-message-id="'+ index +'">' + '<a href="#">' +  locationByCategory.title + '</a>' + '</li>';
			}
		}
		$('#trafficListing').html(trafficListing);
	}

}
window.onload = TrafficInfo.init;
*/