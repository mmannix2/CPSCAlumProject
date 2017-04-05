var app = angular.module('CPSCDatabase', []);
//var app = angular.module('CPSCDatabase', ['ngCookies']);

app.factory('dataFactory', ['$http',
    function($http) {
        return {
            getJobs: function () {
                var promise = $http.get('/api/jobs')
                .then(function (response) {
                    console.log(response.data);
                    return response.data;
                }, function (response) {
                    //Error
                    console.log(response.error);
                });
                return promise;
            },
            postJob: function (postJobInfo) {
                var promise = $http.post('/api/jobs', postJobInfo) 
                .then(function (response){
                    console.log(response.data);
                    return response.data;
                }, function (response){
                    //Error
                    console.log(response.error);
                    console.log(response.message);
                });
                return promise;
            },
            getVolunteers: function () {
                var promise = $http.get('/api/volunteers')
                .then(function (response) {
                    console.log(response.data);
                    return response.data;
                }, function (response) {
                    //Error
                    console.log(response.error);
                });
                return promise;
            },
            postVolunteer: function (postVolunteerInfo) {
                var promise = $http.post('/api/volunteers', postVolunteerInfo) 
                .then(function (response){
                    console.log(response.data);
                    return response.data;
                }, function (response){
                    //Error
                    console.log(response.error);
                    console.log(response.message);
                });
                return promise;
            },
            //If the correct credentials are given, a token is returned
            login: function (loginInfo) {
                var promise = $http.post('/api/login', loginInfo)
                .then(function (response){
                    console.log("Response: " + response.status + " " + response.statusText);
                    console.log("Login Succeded.");
                    console.log(response.data);
                    return response.data;
                }, function(response){
                    console.log("Response: " + response.status + " " + response.statusText);
                    console.log("Login Authentication failed.")
                    return undefined;
                });
                return promise;
            }
        };
    }
]);

/*
app.controller('controller', ['$scope', '$cookie', 'dataFactory' ,
    function ($scope, $cookie, dataFactory) {
*/
app.controller('controller', ['$scope', 'dataFactory' ,
    function ($scope, dataFactory) {
        
        //$scope.adminKey = $cookie.get('adminKey');
        
        $scope.jobs = undefined;
        $scope.volunteers = undefined;
        
        //Contains the data from the search jobs form
        $scope.searchTerms = {
            "jobTitle": undefined,
            "companyName": undefined,
            "keywords": undefined,
            "location": undefined,
            "distance": undefined
        }; 
        
        //Contains the data from the log in form
        $scope.loginInfo = {
            "username": undefined,
            "password": undefined
        }; 
        
        //Contains the data from the post a job form
        $scope.postJobInfo = {
            "jobTitle": undefined,
            "companyName": undefined,
            "description": undefined,
            "location": undefined,
            "email": undefined,
            "link": undefined
        };
        
        $scope.postJobStatus = "Job not yet submitted.";
        
        //Contains the data from a volunteer
        $scope.postVolunteerInfo = {
            "name": undefined,
            "email": undefined,
            "description": undefined
        };
        
        $scope.postVolunteerStatus = "Volunteer not yet submitted.";
        
        dataFactory.getJobs().then(function (data) {
            $scope.jobs = data;
        }, function (error) {
            console.log(error);
        });
        
        dataFactory.getVolunteers().then(function (data) {
            $scope.volunteers = data;
        }, function (error) {
            console.log(error);
        });
        
        $scope.postJobClicked = function postJobClicked() {
            console.log("Trying to post a job.");
            console.log($scope.postJobInfo);
            dataFactory.postJob($scope.postJobInfo);
            /* TODO Find a way to notify the user that the form was submitted successfully.
            if(success == true ) {
                $scope.postJobStatus = "Job posted successfully!";
                $scope.$apply();
            }
            */
        };
        
        $scope.postVolunteerClicked = function postVolunteerClicked() {
            console.log("Trying to post a volunteer.");
            console.log($scope.postVolunteerInfo);
            dataFactory.postVolunteer($scope.postVolunteerInfo);
        };
        
        //Currently only captures input and prints it to the console
        $scope.searchJobs = function searchJobs() {
            console.log($scope.searchTerms);
        };
        
        //Currently only captures input and prints it to the console
        $scope.loginClicked = function loginClicked() {
            console.log($scope.loginInfo);
            //$cookie.put('adminKey', dataFactory.login($scope.loginInfo));
        };
    }
]);