/**
 * Created by sislex on 13.02.16.
 */

if(!myApp){
    var myApp = angular.module('myApp', ["checklist-model"]);

    myApp.filter('ceil', function() {
        return function(input) {
            return Math.ceil(input);
        };
    });
}

myApp.controller('lastCarsWidget', ['$scope', '$http',
    function($scope, $http) {
        $scope.filter = {};
        (function(){
            $http.post('/admin/get/items/8', {name:'type_auto', check:'published'}).
                success(function(data, status, headers, config) {
                    $scope.items = data;
                    //$scope.cloneItems = angular.copy($scope.items);

                    setTimeout(function(){
                        if(window.AUTOSTARS){
                            window.AUTOSTARS.OwlCarousel($('#vehicle-slider'));
                        }
                    }, 500);

                }).
                error(function(data, status, headers, config) {
                    console.log('ошибка при отправке объекта');
                });
            $http.post('/admin/settings/currencies/getCurrencies').
                success(function(data, status, headers, config) {
                    $scope.currencies = data;
                    //console.log($scope.currencies);
                }).
                error(function(data, status, headers, config) {
                    console.log('Ошибка при отправки объекта');
                });
        })();
    }
]);

myApp.controller('lastNewsWidget', ['$scope', '$http',
    function($scope, $http) {
        $scope.getLastNews = function(limit){
            $http.post('/news/last', {type:'news', limit:limit}).
                success(function(data, status, headers, config) {
                    $scope.news = data;
                    setTimeout(function(){
                        if(window.AUTOSTARS){window.AUTOSTARS.OwlCarousel($('#news-slider'));}
                    }, 500);
                }).
                error(function(data, status, headers, config) {
                    console.log('ошибка при отправке объекта');
                });
        };
    }
]);

myApp.controller('lastBlogPostsWidget', ['$scope', '$http',
    function($scope, $http) {
        $scope.func = (function(){
            $http.post('/blog/last', {type:'blog', limit:5}).
            success(function(data, status, headers, config) {
                $scope.blog = data;
                // console.log($scope.blog);
            }).
            error(function(data, status, headers, config) {
                console.log('ошибка при отправке объекта');
            });
        })();
    }
]);

myApp.controller('PartnersWidget', ['$scope', '$http',
  function($scope, $http) {
      $scope.func = (function(){
          $http.get('/partners').
            success(function(data, status, headers, config) {
                $scope.partners = data;
                // console.log($scope.partners);                
                setTimeout(function(){
                        if(window.AUTOSTARS){window.AUTOSTARS.OwlCarousel($('#partners-slider'));}
                    }, 500);
            }).
            error(function(data, status, headers, config) {
                console.log('ошибка при отправке объекта');
            });
        })();
    }
]);

myApp.controller('FeedbacksWidget', ['$scope', '$http',
  function($scope, $http) {
      $scope.func = (function(){
          $http.get('/feedbacks').
            success(function(data, status, headers, config) {
                $scope.feedbacks = data;
                // console.log($scope.partners);                
                setTimeout(function(){
                        if(window.AUTOSTARS){window.AUTOSTARS.OwlCarousel($('#feedbacks-slider'));}
                    }, 500);
            }).
            error(function(data, status, headers, config) {
                console.log('ошибка при отправке объекта');
            });
        })();
    }
]);

myApp.controller('callMeBackWidget', ['$scope', '$http',
    function($scope, $http) {
        $scope.ok = function(selector){
            var ok = $('<div class="ok"><div class="shadow"></div><div class="text"> Отправлено! </div></div>');
            $(selector).prepend(ok);
            $(selector + ' .ok').fadeIn(1500, function(){
                //$(selector + ' .ok').remove();
            });
        };
        // $scope.notOk = function(selector){
        //     var notOk = $('<div class="notOk"><div class="shadow"></div><div class="text"> Ошибка! Вы не указали телефон. </div></div>');
        //     $(selector).prepend(notOk);
        //     $(selector + ' .notOk').fadeIn(1500, function(){
        //         //$(selector + ' .ok').remove();
        //     });
        // };
        $scope.callMeBack = {
            type : 'Заказ обратного звонка',
            name : '',
            email : '',
            phone : '',
            comment : '',
            subscribe : false,
            url : window.location.href,

            // Добавлено для произвольной формы заказа авто
            mark: '',
            model: '',
            year: '',
            price: '',
            engine: '',
            body: '',
            transmission: '',
            // ---

            send : function(){
                if ($scope.callMeBack.phone.trim() != '') {
                    $scope.ok('#callMeBackWidget');
                    $http.post('/mail/index',{callMeBackWidget : $scope.callMeBack})
                        .success(function(data, status, headers, config){
                            console.log('запрос отправлен успешно');
                            $scope.callMeBack.clear();
                        })
                        .error(function(data, status, headers, config){
                            console.log('ошибка при отправке запроса');
                            $scope.callMeBack.clear();
                        });
                } else {
                    // do nothing
                }
            },
            clear : function(){
                $scope.callMeBack.name = '';
                $scope.callMeBack.email = '';
                $scope.callMeBack.phone = '';
                $scope.callMeBack.comment = '';
                $scope.callMeBack.subscribe = false;

                // Добавлено для произвольной формы заказа авто
                $scope.callMeBack.mark = '';
                $scope.callMeBack.model = '';
                $scope.callMeBack.year = '';
                $scope.callMeBack.price = '';
                $scope.callMeBack.engine = '';
                $scope.callMeBack.body = '';
                $scope.callMeBack.transmission = '';
                // ---
            }
        };
    }
]);

myApp.controller('subscribeWidget', ['$scope', '$http',
    function($scope, $http) {
        $scope.ok = function(selector){
            var ok = $('<div class="ok"><div class="shadow"></div><div class="text"> Отправлено! </div></div>');
            $(selector).prepend(ok);
            $(selector + ' .ok').fadeIn(1500, function(){
                //$(selector + ' .ok').remove();
            });
        };
        $scope.subscribe = {
            name : '',
            type : 'Подписка на рассылку',
            email : '',

            send : function(){
                $scope.ok('#subscribeWidget');
                $http.post('/mail/index',{subscribeWidget : $scope.subscribe})
                    .success(function(data, status, headers, config){
                        console.log('запрос отправлен успешно');
                        $scope.subscribe.clear();
                    })
                    .error(function(data, status, headers, config){
                        console.log('ошибка при отправке запроса');
                        $scope.subscribe.clear();
                    });
            },
            clear : function(){
                $scope.subscribe.name = '';
                $scope.subscribe.email = '';
            }
        };
    }
]);


if(!mailApp){
    var mailApp = angular.module('mailApp', []);
}

mailApp.controller('mailWidget', ['$scope', '$http',
    function($scope, $http) {
        $scope.ok = function(selector){
            var ok = $('<div class="ok"><div class="shadow"></div><div class="text"> Отправлено! </div></div>');
            $(selector + ' .modal-content').prepend(ok);
            $(selector + ' .ok').fadeIn(1500, function(){
                $(selector + ' .ok').remove();
                $(selector).modal('hide');
            });
        };
        $scope.infoModal = {
            type : 'Запрос дополнительной информации',
            name : '',
            email : '',
            phone : '',
            url : window.location.href,
            send : function(){
                if ($scope.infoModal.phone.trim() != '') {
                    $scope.ok('#infoModal');

                    $http.post('/mail/index',{modal : $scope.infoModal})
                        .success(function(data, status, headers, config){
                            console.log('запрос отправлен успешно');
                            $scope.infoModal.clear();
                        })
                        .error(function(data, status, headers, config){
                            console.log('ошибка при отправке запроса');
                            $scope.infoModal.clear();
                        });
                } else {

                }
            },
            clear : function(){
                $scope.infoModal.name = '';
                $scope.infoModal.email = '';
                $scope.infoModal.phone = '';
            }
        };
        $scope.offerModal = {
            type : 'Предложение своей цены',
            name : '',
            email : '',
            phone : '',
            price : '',
            comment : '',
            url : window.location.href,
            send : function(){
                if ($scope.offerModal.phone.trim() != '') {
                    $scope.ok('#offerModal');

                    $http.post('/mail/index',{modal : $scope.offerModal})
                        .success(function(data, status, headers, config){
                            console.log('запрос отправлен успешно');
                            $scope.offerModal.clear();
                        })
                        .error(function(data, status, headers, config){
                            console.log('ошибка при отправке запроса');
                            $scope.offerModal.clear();
                        });
                } else {
                    // do nothing
                }
            },
            clear : function(){
                $scope.offerModal.name = '';
                $scope.offerModal.email = '';
                $scope.offerModal.phone = '';
                $scope.offerModal.price = '';
                $scope.offerModal.comment = '';
            }
        };
        $scope.testdriveModal = {
            type : 'Запись на тест-драйв',
            name : '',
            email : '',
            phone : '',
            date : '',
            time : '',
            url : window.location.href,
            send : function(){
                if ($scope.testdriveModal.phone.trim() != '') {
                    $scope.ok('#testdriveModal');

                    $http.post('/mail/index',{modal : $scope.testdriveModal})
                        .success(function(data, status, headers, config){
                            console.log('запрос отправлен успешно');
                            $scope.testdriveModal.clear();
                        })
                        .error(function(data, status, headers, config){
                            console.log('ошибка при отправке запроса');
                            $scope.testdriveModal.clear();
                        });
                } else {
                    // do nothing
                }
            },
            clear : function(){
                $scope.testdriveModal.name = '';
                $scope.testdriveModal.email = '';
                $scope.testdriveModal.phone = '';
                $scope.testdriveModal.date = '';
                $scope.testdriveModal.time = '';
            }
        };
        $scope.sendModal = {
            type : 'Поделиться ссылкой',
            name : '',
            email : '',
            friend : '',
            message : '',
            url : window.location.href,
            send : function(){
                $scope.ok('#sendModal');

                $http.post('/mail/index',{modal : $scope.sendModal})
                    .success(function(data, status, headers, config){
                        console.log('запрос отправлен успешно');
                        $scope.sendModal.clear();
                    })
                    .error(function(data, status, headers, config){
                        console.log('ошибка при отправке запроса');
                        $scope.sendModal.clear();
                    });
            },
            clear : function(){
                $scope.sendModal.name = '';
                $scope.sendModal.email = '';
                $scope.sendModal.friend = '';
                $scope.sendModal.message = '';
            }
        };
    }
]);

var divMyApp = document.getElementById('divMyApp');
var divMailApp = document.getElementById('divMailApp');

angular.element(document).ready(function(){
    angular.bootstrap(divMyApp, ['myApp']);
    angular.bootstrap(divMailApp, ['mailApp']);
});