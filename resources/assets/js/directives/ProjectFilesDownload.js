angular.module('app.directives')
			.directive('projectFilesDownload', ['appConfig', 'ProjectFiles', function(appConfig, ProjectFiles){
				return {
					restrict: 'E',
					templateUrl: appConfig.baseUrl + '/build/views/templates/ProjectFilesDownload.html',
					link: function(scope, element, attr){
						
					},
					controller: ['$scope', '$element', '$attrs', '$timeout', function($scope, $element, $attrs, $timeout){
						$scope.downloadFile = function(){
							var anchor = $element.children()[0];
							$(anchor).addClass('disabled');
							$(anchor).text('Carregando...');
							ProjectFiles.download({id: null, idFile: $attrs.idFile}, function(data){
								$(anchor).removeClass('disabled');
								$(anchor).text('Download');
								$(anchor).attr({
									href: 'data:application-octet-stream;base64,' + data.file,
									download: data.name
								});
								
								$timeout(function(){
									$scope.downloadFile = function(){
										
									};
									$(anchor)[0].click();
								});
								
							});
						}
					}]
				};
			}]);