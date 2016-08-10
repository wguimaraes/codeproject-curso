angular.module('app.services')
			.service('Project',
			['$resource', '$filter', '$httpParamSerializer', 'appConfig',
			function($resource, $filter, $httpParamSerializer, appConfig){
				
				function transformData(data){
					if(angular.isObject(data) && data.hasOwnProperty('due_date')){
						var o = angular.copy(data);
						o.due_date = $filter('date')(o.due_date, 'yyyy-MM-dd');
						return appConfig.utils.transformRequest(o);
					}
					return data;
				};
				
				return $resource(appConfig.baseUrl + '/project/:id', {id: '@id'},{
					save: {
						method: 'POST'
					},
					get: {
						method: 'GET'
					},
					update: {
						method: 'PUT'
					}
				});
			}]);