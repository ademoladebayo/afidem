// /*
// Give the service worker access to Firebase Messaging.
// Note that you can only use Firebase Messaging here, other Firebase libraries are not available in the service worker.
importScripts("https://www.gstatic.com/firebasejs/7.23.0/firebase-app.js");
importScripts(
  "https://www.gstatic.com/firebasejs/7.23.0/firebase-messaging.js"
);

/*
Initialize the Firebase app in the service worker by passing in the messagingSenderId.
* New configuration for app@pulseservice.com
*/
firebase.initializeApp({
  apiKey: "AIzaSyCLhWTc_4e5rGJeXV8qGCWZdZLTP0YrjCA",
  authDomain: "dextroux-technologies.firebaseapp.com",
  projectId: "dextroux-technologies",
  storageBucket: "dextroux-technologies.appspot.com",
  messagingSenderId: "1099192792266",
  appId: "1:1099192792266:web:2da00b0f913d84ec4ef033",
  measurementId: "G-QWNY4DPSNH",
});

/*
Retrieve an instance of Firebase Messaging so that it can handle background messages.
*/
const messaging = firebase.messaging();
messaging.setBackgroundMessageHandler(function (payload) {
  console.log(
    "[firebase-messaging-sw.js] Received background message ",
    payload
  );
  /* Customize notification here */
  const notificationTitle = "Background Message Title";
  const notificationOptions = {
    body: "Background Message body.",
    icon: "/itwonders-web-logo.png",
  };

  return self.registration.showNotification(
    notificationTitle,
    notificationOptions
  );
});
// --------------------------------------------------------------------------------------------------
// importScripts(
//   "https://www.gstatic.com/firebasejs/9.14.0/firebase-app-compat.js"
// );
// importScripts(
//   "https://www.gstatic.com/firebasejs/9.14.0/firebase-messaging-compat.js"
// );

// const firebaseConfig = {
//   apiKey: "AIzaSyCLhWTc_4e5rGJeXV8qGCWZdZLTP0YrjCA",
//   authDomain: "dextroux-technologies.firebaseapp.com",
//   projectId: "dextroux-technologies",
//   storageBucket: "dextroux-technologies.appspot.com",
//   messagingSenderId: "1099192792266",
//   appId: "1:1099192792266:web:2da00b0f913d84ec4ef033",
//   measurementId: "G-QWNY4DPSNH",
// };

// // Initialize Firebase
// const app = firebase.initializeApp(firebaseConfig);
// const messaging = firebase.messaging();
// messaging.onBackgroundMessage(function (payload) {
//   console.log('out app notify ', payload);

//   // Customize notification here
//   const notificationTitle = payload.data.title;
//   const notificationOptions = {
//     body: payload.data.body,
//     icon: payload.data.icon,
//     image: payload.data.image,
//   };

//   self.registration.showNotification(notificationTitle, notificationOptions);
//   self.addEventListener("notificationclick", function (event) {
//     const clickedNotification = event.notification;
//     clickedNotification.close();
//     event.waitUntil(clients.openWindow(payload.data.click_action));
//   });
// });
