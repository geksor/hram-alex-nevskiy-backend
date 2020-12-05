importScripts('https://www.gstatic.com/firebasejs/8.1.2/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/6.1.0/firebase-messaging.js');

const firebaseConfig = {
    apiKey: "AIzaSyAwC6wFnNJ6Qv9inKd10Ik3gzZhXOuU4xc",
    authDomain: "hramalexnevsciyapp.firebaseapp.com",
    projectId: "hramalexnevsciyapp",
    storageBucket: "hramalexnevsciyapp.appspot.com",
    messagingSenderId: "209539708545",
    appId: "1:209539708545:web:e9f2b3abb77a5914a13f80",
    measurementId: "G-R6SZ2ETQ1E"
};

firebase.initializeApp(firebaseConfig);

const messaging = firebase.messaging();