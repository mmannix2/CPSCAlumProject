//var app = angular.module('CPSCDatabase', ['ngCookies', 'ngRoute']);
var app = angular.module('CPSCDatabase', ['ngCookies']);

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
                .then(function (response) {
                    console.log(response.data);
                    return response.data;
                }, function (response) {
                    //Error
                    console.log(response.error);
                    console.log(response.message);
                });
                return promise;
            },
            //If the correct credentials are given, a token is returned
            login: function (loginInfo) {
                var promise = $http.post('/api/login', loginInfo)
                .then(function (response) {
                    console.log("Response: " + response.status + " " + response.statusText);
                    console.log("Login succeded.");
                    console.log(response.data);
                    return response.data;
                }, function(response) {
                    console.log("Response: " + response.status + " " + response.statusText);
                    console.log("Login authentication failed.");
                    return undefined;
                });
                return promise;
            },
            deleteJob: function (jobNumber) {
                var promise = $http.delete('/api/jobs/'.concat(jobNumber))
                .then(function (response) {
                    console.log("Response: " + response.status + " " + response.statusText);
                    console.log("Deleted job.");
                }, function(response){
                    console.log("Response: " + response.status + " " + response.statusText);
                    console.log("Failed to delete job.");
                });
                return promise;
            },
            deleteVolunteer: function (volunteerNumber) {
                var promise = $http.delete('/api/volunteers/'.concat(volunteerNumber))
                .then(function (response) {
                    console.log("Response: " + response.status + " " + response.statusText);
                    console.log("Deleted volunteer.");
                }, function(response){
                    console.log("Response: " + response.status + " " + response.statusText);
                    console.log("Failed to delete volunteer.");
                });
                return promise;
            },
            getAnnouncements: function () {
                var promise = $http.get('/api/announcements/')
                .then(function (response) {
                    console.log(response.data);
                    return response.data;
                }, function (response) {
                    //Error
                    console.log(response.error);
                });
                return promise;
            },
            postAnnouncement: function (postAnnouncementInfo) {
                var promise = $http.post('/api/announcements', postAnnouncementInfo) 
                .then(function (response) {
                    console.log(response.data);
                    return response.data;
                }, function (response) {
                    //Error
                    console.log(response.error);
                    console.log(response.message);
                });
                return promise;
            },
        };
    }
]);

app.controller('controller', ['$scope', '$cookies', 'dataFactory' ,
    function ($scope, $cookies, dataFactory) {
        
        $scope.adminKey = $cookies.get('adminKey');
        
        console.log("adminKey: " + $scope.adminKey);
        
        $scope.jobs = undefined;
        $scope.volunteers = undefined;
        $scope.announcements = undefined;
        
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
        
        $scope.postVolunteerStatus = "Volunteer data not yet submitted.";
        
        //Contains the data from an announcement
        $scope.postAnnouncementInfo = {
            "title": undefined,
            "description": undefined
        };
        
        $scope.postAnnouncementStatus = "Announcement not yet submitted.";
        
        dataFactory.getJobs().then(function (data) {
            $scope.jobs = data;
        }, function (error) {
            console.log(error);
        });
        
        dataFactory.getAnnouncements().then(function (data) {
            $scope.announcements = data;
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
            $scope.postJobInfo=[];
        };
        
        $scope.postVolunteerClicked = function postVolunteerClicked() {
            console.log("Trying to post a volunteer.");
            console.log($scope.postVolunteerInfo);
            dataFactory.postVolunteer($scope.postVolunteerInfo);
            $scope.postVolunteerInfo=[];
        };
        
        $scope.postAnnouncementClicked = function postAnnouncementClicked() {
            console.log("Trying to post an Announcement.");
            console.log($scope.postAnnouncementInfo);
            dataFactory.postAnnouncement($scope.postAnnouncementInfo);
            $scope.postAnnouncementInfo=[];
        };
        
        //Currently only captures input and prints it to the console
        $scope.searchJobs = function searchJobs() {
            console.log($scope.searchTerms);
        };
        
        //Currently only captures input and prints it to the console
        $scope.loginClicked = function loginClicked() {
            console.log($scope.loginInfo);
            console.log("Logging in.");
            $cookies.put('adminKey', dataFactory.login($scope.loginInfo));
            $scope.adminKey = $cookies.get('adminKey');
            $scope.$apply();
        };
        
        $scope.logoutClicked = function logoutClicked() {
            console.log("Logging out.");
            $cookies.put('adminKey', undefined);
            $scope.adminKey = undefined;
            $scope.$apply();
        };
    
        $scope.deleteJobClicked = function deleteJobClicked(jobNumber) {
            console.log("Deleting job #" + jobNumber);
            dataFactory.deleteJob(jobNumber);
            
            //Delete the job from $scope.jobs
            var i = 0;
            for(var len = $scope.jobs.length; i < len; i++) {
                if($scope.jobs[i].id == jobNumber) {
                    break;
                }
            }
            $scope.jobs.splice(i, 1);
            //$scope.$apply();
        };
        
        $scope.deleteVolunteerClicked = function deleteVolunteerClicked(volunteerNumber) {
            console.log("Deleting volunteer #" + volunteerNumber);
            dataFactory.deleteVolunteer(volunteerNumber);
            
            //Delete the volunteer from $scope.volunteers
            var i = 0;
            for(var len = $scope.volunteers.length; i < len; i++) {
                if($scope.volunteers[i].id == volunteerNumber) {
                    break;
                }
            }
            $scope.volunteers.splice(i, 1);
            //$scope.$apply();
        };
    }
]);