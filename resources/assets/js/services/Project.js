angular.module('app.services')
			.service('Project',
			['$resource', '$filter', '$httpParamSerializer', 'appConfig',
			function($resource, $filter, $httpParamSerializer, appConfig){
				
				return $resource(appConfig.baseUrl + '/project/:id', {id: '@id'},{
					save: {
						method: 'POST'
					},
					get: {
						method: 'GET',
						transformResponse: function(data, headers){
							var o = appConfig.utils.transformResponse(data, headers);
							if(angular.isObject(o) && o.hasOwnProperty('due_date')){
								var arrayData = o.due_date.split('-');
								var month = parseInt(arrayData[1]) - 1;
								o.due_date = new Date(arrayData[0], month, arrayData[2]);
							}
							return o;
						}
					},
					update: {
							method: 'PUT'
						}
				});
			}]);