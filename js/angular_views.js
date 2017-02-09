(function ($, Drupal) {
  Drupal.behaviors.angularViews = {
    attach: function (context, settings) {
    var app = angular.module('myApp', []);
app.controller('viewsCtrl', function($scope, $http) {
    $http.get("http://drupal-demo.dd:8083/json-service")
    .then(function (response) {
		$scope.parentrows = response.data;
		});
});
	
    }
  };
})(jQuery, Drupal);