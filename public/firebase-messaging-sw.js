/*
Give the service worker access to Firebase Messaging.
Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
*/
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js');
importScripts('https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js');
   
/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
        apiKey: "AIzaSyDAtEY4fUD9cBR0A3Jvshtvpw4ap8Yi_uY",
        authDomain: "test-notification-821ad.firebaseapp.com",
        databaseURL: "https://test-notification-821ad-default-rtdb.firebaseio.com/",
        projectId: "test-notification-821ad",
        storageBucket: "test-notification-821ad.appspot.com",
        messagingSenderId: "1059480040273",
        appId: "1:1059480040273:web:4cd840d2a2e705319f5970",
        measurementId: "G-5PJ5E74LCB"
    });
  
/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function(payload) {
    console.log(
        "[firebase-messaging-sw.js] Received background message ",
        payload,
    );
    /* Customize notification here */
    const notificationTitle = "Background Message Title";
    const notificationOptions = {
        body: "Background Message body.",
        icon: "/itwonders-web-logo.png",
    };
  
    return self.registration.showNotification(
        notificationTitle,
        notificationOptions,
    );
});