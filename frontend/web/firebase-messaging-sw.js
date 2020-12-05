importScripts('https://www.gstatic.com/firebasejs/6.1.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/6.1.0/firebase-messaging.js');

var firebaseConfig = {
    apiKey: "AIzaSyD0qcvW_tFguqTa2hm1MyHVHDdaDPwTUig",
    authDomain: "blagoapp-ab505.firebaseapp.com",
    databaseURL: "https://blagoapp-ab505.firebaseio.com",
    projectId: "blagoapp-ab505",
    storageBucket: "",
    messagingSenderId: "278659335394",
    appId: "1:278659335394:web:04a683ed361f3e81"
};

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();