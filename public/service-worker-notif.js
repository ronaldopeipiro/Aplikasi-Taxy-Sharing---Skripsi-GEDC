"use strict";
var promises = [];

self.addEventListener("push", async function (e) {
  var body;
  // const analyticsPromise = pushReceivedTracking();

  if (e.data) {
    body = e.data.text();
  } else {
    body = "Push message no payload";
  }

  var options = {
    body: body,
    icon: "https://jo.yokcaridok.id/assets/img/logo.jpg",
    vibrate: [100, 50, 100, 100, 100, 50, 100],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: 1,
    },
    actions: [
      {
        action: "explore",
        title: "Buka",
        icon: "https://jo.yokcaridok.id/assets/img/checkmark.png",
      },
      {
        action: "close",
        title: "Tutup",
        icon: "https://jo.yokcaridok.id/assets/img/xmark.png",
      },
    ],
  };

  promises.push(
    self.registration.showNotification("AIRPORT TAXI SHARING", options)
  );
  Promise.all(promises);
});

// self.addEventListener("notificationclick", function (event) {
//   console.log("[Service Worker] Notification click Received.");
//   event.notification.close();
//   event.waitUntil(clients.openWindow("https//jo.yokcaridok.id/pelapor"));
// });
