// Firebase
var config = {
    apiKey: "AIzaSyBmaS0B0qwokES4a_CiFNVkVJGkimXkNsk",
  authDomain: "fir-demo-application-appsnado.firebaseapp.com",
  projectId: "fir-demo-application-appsnado",
  storageBucket: "fir-demo-application-appsnado.appspot.com",
  messagingSenderId: "444368355777",
  appId: "1:444368355777:web:633ac47fe767fa6c6d6f40",
    measurementId: "G-8Z5WDYV4Q0"
};
firebase.initializeApp(config);
// End Firebase

/** Get token */
// firebase.initializeApp(config);
const messaging = firebase.messaging();
function initFirebaseMessagingRegistration() {
    messaging
        .requestPermission()
        .then(function () {
            return messaging.getToken()
        })
        .then(function (token) {
            $('#device_token').val(token);
        }).catch(function (err) {
            console.log('User Chat Token Error *** ' + err);
        });
}
messaging.onMessage(function (payload) {
    const noteTitle = payload.notification.title;
    const noteOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon,
    };
    new Notification(noteTitle, noteOptions);
});
initFirebaseMessagingRegistration();