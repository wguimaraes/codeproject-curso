var app = angular.module('app', ['ngRoute', 'angular-oauth2', 'app.controllers', 'app.services']);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2']);
angular.module('app.services', ['ngResource']);

app.provider('appConfig', function(){
	var config = {
		baseUrl: 'http://localhost:8000'
	}
	
	return {
		config: config,
		$get: function(){
			return config;
		}
	}
})

app.config(['$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider', 
            function($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider){
		$httpProvider.defaults.transformResponse = function(data, headers){
			var headersGetter = headers();
			if(headersGetter['content-type'] == 'application/json' || headersGetter['content-type'] == 'text/json'){
				var dataJson = JSON.parse(data);
				if(dataJson.hasOwnProperty('data')){
					dataJson = dataJson.data;
				}
				return dataJson;
			}
			return data;
		};
    	$routeProvider
            .when('/login', {
                templateUrl: 'build/views/login.html',
                controller: 'LoginController'
            })
            .when('/home', {
                templateUrl: 'build/views/home.html',
                controller: 'HomeController'
            })
            .when('/clients', {
                templateUrl: 'build/views/clients/list.html',
                controller: 'ClientListController'
            })
            .when('/clients/new', {
                templateUrl: 'build/views/clients/new.html',
                controller: 'ClientNewController'
            })
            .when('/clients/:id/edit', {
                templateUrl: 'build/views/clients/edit.html',
                controller: 'ClientEditController'
            })
            .when('/clients/:id/remove', {
                templateUrl: 'build/views/clients/remove.html',
                controller: 'ClientRemoveController'
            })
            .when('/project/:id/notes', {
                templateUrl: 'build/views/projects/notes/list.html',
                controller: 'ProjectNotesController'
            })
            .when('/project/:id/notes/show/:idNote', {
                templateUrl: 'build/views/projects/notes/show.html',
                controller: 'ProjectNotesShowController'
            })
            .when('/project/:id/notes/new', {
                templateUrl: 'build/views/projects/notes/new.html',
                controller: 'ProjectNotesController'
            })
            .when('/project/:id/notes/:idNote/edit', {
                templateUrl: 'build/views/projects/notes/edit.html',
                controller: 'ProjectNotesController'
            })
            .when('/project/:id/notes/:idNote/remove/', {
                templateUrl: 'build/views/projects/notes/remove.html',
                controller: 'ProjectNotesController'
            });
    OAuthProvider.configure({
        baseUrl: appConfigProvider.config.baseUrl,
        clientId: 'appid1',
        clientSecret: 'secret',
        grantPath: '/oauth/access_token'
    });
    OAuthTokenProvider.configure({
    	name: 'token',
    	options: {
    		secure: false
    	}
    });
}]);

app.run(['$rootScope', '$window', 'OAuth', function($rootScope, $window, OAuth) {
    $rootScope.$on('oauth:error', function(event, rejection) {
      // Ignore `invalid_grant` error - should be catched on `LoginController`.
      if ('invalid_grant' === rejection.data.error) {
        return;
      }

      // Refresh token when a `invalid_token` error occurs.
      if ('invalid_token' === rejection.data.error) {
        return OAuth.getRefreshToken();
      }

      // Redirect to `/login` with the `error_reason`.
      return $window.location.href = '/#login?error_reason=' + rejection.data.error;
    });
}]);