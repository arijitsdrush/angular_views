(function ($, Drupal) {
    Drupal.behaviors.angularViews = {
        attach: function (context, settings) {
            
			var app = angular.module('angularViews', ['ngSanitize']);
			
            app.controller('viewsCtrl', function ($scope, $http) {
                $http.get(settings.angularViews.service_backend)
                    .then(function (response) {
                        $scope.parentrows = response.data;
						$scope.hide_loader = true;
						$scope.show_result_success = true;
                    })
					.catch(function (data) {
						$scope.hide_loader = true;
						$scope.show_result_success = false;
						$scope.show_result_fail = true;
					});
            });

        }
    };
})(jQuery, Drupal);
