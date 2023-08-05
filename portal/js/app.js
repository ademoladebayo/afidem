const version = "1.1"; // Change this to a new value whenever you update the service worker

if ("serviceWorker" in navigator) {
  // UNREGISTER OLD SERVICE WORKER
  navigator.serviceWorker.getRegistrations().then((registrations) => {
    for (const registration of registrations) {
      registration.unregister();
    }
  });

  window.addEventListener("load", function () {
    navigator.serviceWorker
      .register(`./serviceWorker.js?v=${version}`)
      .then((res) => console.log("service worker registered v" + version))
      .catch((err) => console.log("service worker not registered", err));
  });
}
