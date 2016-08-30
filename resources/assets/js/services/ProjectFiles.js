angular.module('app.services')
			.service('ProjectFiles', ['$resource', 'appConfig', 'Url', function($resource, appConfig, Url){
				var url = appConfig.baseUrl + Url.getUrlResource(appConfig.urls.projectFile);
				return $resource(url,
				{
					id: '@id',
					idFile: '@idFile'
				},
				{
					update: {
						method: 'PUT'
					},
					download: {
						method: 'GET',
						url: url + '/download'
					}
				});
			}]);