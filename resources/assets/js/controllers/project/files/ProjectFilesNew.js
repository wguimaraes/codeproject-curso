angular.module('app.controllers')
        .controller('ProjectFilesNewController', ['$scope', '$location', '$routeParams', 'Upload', 'appConfig', 'Url', 'ProjectFiles',
                                                  function($scope, $location, $routeParams, Upload, appConfig, Url, ProjectFiles){
            $scope.file = {
            		project_id: $routeParams.id
            };
            
            $scope.save = function(){
            	if($scope.form.$valid){	
        			var url = appConfig.baseUrl +
            				Url.getUrlFromUrlSymbol(appConfig.urls.projectFile, {
	                        	id: $routeParams.id,
	                        	idFile: ''
	                        });
        			
        			Upload.upload({
        	            url: url,
        	            data: {
        	            	file: $scope.file.file,
        	            	'name': $scope.file.name,
        	            	'description': $scope.file.description,
        	            	'project_id': $scope.file.project_id
        	            }
        	        }).then(function (resp) {
        	        	$location.path('project/' + $routeParams.id + '/files');
        	        });
            	}
            }
        }]);