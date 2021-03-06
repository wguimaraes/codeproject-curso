var app = angular.module('app', 
		['ngRoute', 'angular-oauth2', 'app.controllers', 'app.services', 'app.filters', 'app.directives',
		 'ui.bootstrap.typeahead', 'ui.bootstrap.datepicker', 'ui.bootstrap.tpls', 'ngFileUpload']);

angular.module('app.controllers', ['ngMessages', 'angular-oauth2']);
angular.module('app.filters', []);
angular.module('app.services', ['ngResource']);
angular.module('app.directives', []);

app.provider('appConfig', ['$httpParamSerializerProvider', function($httpParamSerializerProvider){
	var config = {
		baseUrl: 'http://localhost:8000',
		project: {
			status: [
			           {value: 1, label: 'Não iniciado'},
			           {value: 2, label: 'Iniciado'},
			           {value: 3, label: 'Finalizado'}
			        ]
		},
		
		urls: {
			projectFile: '/project/{{id}}/files/{{idFile}}'
		},
		
		utils: {
			transformRequest: function(data){
				if(angular.isObject(data)){
					return $httpParamSerializerProvider.$get()(data);
				}
			},
			transformResponse: function(data, headers){
				var headersGetter = headers();
				if(headersGetter['content-type'] == 'application/json' || headersGetter['content-type'] == 'text/json'){
					var dataJson = JSON.parse(data);
					if(dataJson.hasOwnProperty('data')){
						dataJson = dataJson.data;
					}
					if(dataJson.hasOwnProperty('due_date') && !angular.isObject(dataJson.due_date)){
						var arrayDate = dataJson.due_date.split('-');
						dataJson.due_date = new Date(arrayDate[0], (parseInt(arrayDate[1]) - 1), parseInt(arrayDate[2]));
					}
					return dataJson;
				}
				return data;
			}
		}
	}
	
	return {
		config: config,
		$get: function(){
			return config;
		}
	}
}])

app.config(['$routeProvider', '$httpProvider', 'OAuthProvider', 'OAuthTokenProvider', 'appConfigProvider', 
            function($routeProvider, $httpProvider, OAuthProvider, OAuthTokenProvider, appConfigProvider){
				$httpProvider.defaults.transformResponse = appConfigProvider.config.utils.transformResponse;
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
		            .when('/projects', {
		                templateUrl: 'build/views/projects/list.html',
		                controller: 'ProjectListController'
		            })
		            .when('/projects/:id', {
		                templateUrl: 'build/views/projects/new.html',
		                controller: 'ProjectNewController'
		            })
		            .when('/projects/:id/edit', {
		                templateUrl: 'build/views/projects/edit.html',
		                controller: 'ProjectEditController'
		            })
		            .when('/projects/:id/remove', {
		                templateUrl: 'build/views/projects/remove.html',
		                controller: 'ProjectRemoveController'
		            })
		            .when('/project/:id/notes', {
		                templateUrl: 'build/views/projects/notes/list.html',
		                controller: 'ProjectNotesListController'
		            })
		            .when('/project/:id/notes/show/:idNote', {
		                templateUrl: 'build/views/projects/notes/show.html',
		                controller: 'ProjectNotesShowController'
		            })
		            .when('/project/:id/notes/new', {
		                templateUrl: 'build/views/projects/notes/new.html',
		                controller: 'ProjectNotesNewController'
		            })
		            .when('/project/:id/notes/:idNote/edit', {
		                templateUrl: 'build/views/projects/notes/edit.html',
		                controller: 'ProjectNotesEditController'
		            })
		            .when('/project/:id/notes/:idNote/remove/', {
		                templateUrl: 'build/views/projects/notes/remove.html',
		                controller: 'ProjectNotesRemoveController'
		            })
		            .when('/project/:id/files', {
		                templateUrl: 'build/views/projects/files/list.html',
		                controller: 'ProjectFilesListController'
		            })
		            .when('/project/:id/file/new', {
		                templateUrl: 'build/views/projects/files/new.html',
		                controller: 'ProjectFilesNewController'
		            })
		            .when('/project/:id/file/:fileId/edit', {
		                templateUrl: 'build/views/projects/files/edit.html',
		                controller: 'ProjectFilesEditController'
		            })
		            .when('/project/:id/file/:fileId/remove/', {
		                templateUrl: 'build/views/projects/files/remove.html',
		                controller: 'ProjectFilesRemoveController'
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